<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserLog;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $users = User::has('orders')->orderBy('created_at', 'asc')->withCount(['orders'])->paginate(10);
        return view('admin.orders.index', compact('users'));
    }

    public function viewOrders(User $user)
    {
        return view('admin.orders.view', compact('user'));
    }

    public function manageOrders(Request $request, Order $order)
    {
        $statusUpdated = $request->status;

        // Validate the provided status against expected values
        $validStatuses = ['Pending', 'Processing', 'Out for delivery', 'Delivered'];
        if (!in_array($statusUpdated, $validStatuses)) {
            return back()->with('error', 'Invalid status provided');
        }

        // Check the current status and update accordingly
        if ($statusUpdated == "Pending") {
            $statusUpdated = "Processing";
        } elseif ($statusUpdated == "Processing") {
            $statusUpdated = "Out for delivery";
        } elseif ($statusUpdated == "Out for delivery") {
            $statusUpdated = "Delivered";
        } elseif ($statusUpdated == "Delivered") {
            $statusUpdated = "Paid";
        }

        // Update the order status
        $order->update([
            'status' => $statusUpdated,
        ]);

        $log_entry = Auth::user()->name . " marked as " . $statusUpdated . " for " .  $order->user->name . "'s order. " . " with the id# " . $order->id;
        event(new UserLog($log_entry));

        return back()->with('message', 'Order status updated successfully');
    }


    public function searchOrder(Request $request)
    {
        $search = $request->search;

        $users = User::has('orders')->withCount('orders')->where(function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('gender', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%");
        })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.orders.searched', compact('users', 'search'));
    }

    public function createOrder()
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Admin');
        })->get();
        $categories = Category::all();
        $products = Product::all();
        return view('admin.orders.create', compact('users', 'categories', 'products'));
    }
    public function createOrderNow(Request $request)
    {
        $request->validate([
            'product_id'       => ['required'],
            'status'           => ['required'],
            'order_quantity'   => ['required', 'numeric', 'min:1'],
            'user_id'          => ['required']
        ]);

        $product = Product::find($request->product_id);

        if (!$product) {
            return back()->with('error', 'Product not found. Please try again.');
        }

        if ($product->stock == 0) {
            return back()->with('error', 'The product is out of stock.');
        } elseif ($request->order_quantity > $product->stock) {
            return back()->with('error', 'You entered an excess amount. Product stock: ' . $product->stock);
        } else {
            $order = Order::create([
                'product_id'       => $request->product_id,
                'status'           => $request->status,
                'order_quantity'   => $request->order_quantity,
                'user_id'          => $request->user_id
            ]);

            $product->decrement('stock', $order->order_quantity);
            $product->increment('sold', $order->order_quantity);

            $productName = $product->product_name;

            $log_entry = Auth::user()->name . " has ordered a product: " . $productName . " for " . $order->user->name . " with the id# " . $order->id;
            event(new UserLog($log_entry));

            return redirect('/admin/orders')->with('message', 'Successfully ordered a product: ' . $productName . ' for '  . $order->user->name);
        }
    }
}
