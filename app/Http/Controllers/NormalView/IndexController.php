<?php

namespace App\Http\Controllers\NormalView;

use App\Events\UserLog;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function productList()
    {
        $categories = Category::withCount('products')->get();
        $products = Product::where('sold', '>', 0)->orderBy('sold', 'desc')->with('orders')->take(10)->get();
        $allProducts = Product::orderBy('product_name', 'desc')->with('orders')->get();

        return view('normal-view.pages.index', compact('categories', 'products', 'allProducts'));
    }

    public function categoryList(Category $category)
    {

        $categories = Category::orderBy('name', 'asc')->with('products')->get();

        return view('normal-view.pages.category-list', compact('category', 'categories'));
    }

    public function orders()
    {

        $orders = Order::orderBy('created_at', 'asc')->where('user_id', auth()->id())->with('product')->paginate(10);

        return view('normal-view.orders.index', compact('orders'));
    }

    public function confirmOrder(Cart $cart)
    {
        return view('normal-view.orders.confirm-orders', compact('cart'));
    }
    public function confirmQuantity(Product $product)
    {
        return view('normal-view.orders.confirm-quantity', compact('product'));
    }

    public function orderCreate(Request $request, Product $product)
    {
        if ($product) {

            if ($product->stock == 0) {
                return back()->with('error', 'No available products. Please select another one.');
            } else {

                $order = Order::create([
                    'product_id'       => $request->product_id,
                    'order_quantity'   => $request->order_quantity,
                    'status'           => "Pending",
                    'user_id'          => auth()->id()
                ]);

                $product->decrement('stock', $order->order_quantity);
                $product->increment('sold', $order->order_quantity);

                $productName = $product->product_name;

                $log_entry = Auth::user()->name . " has ordered product: " . $productName . " with the id# " . $product->id;
                event(new UserLog($log_entry));

                $cartItem = Cart::where('product_id', $request->product_id)
                    ->where('user_id', auth()->id())
                    ->first();

                if ($cartItem) {
                    $cartItem->delete();
                }

                return redirect('/orders')->with('message', 'Ordered successfully');
            }
        } else {
            return back()->with('error', 'Product not found. Please try again.');
        }
    }

    public function addOrderQuantity(Request $request, Product $product)
    {
        if ($product) {
            if ($product->stock == 0) {
                return back()->with('error', 'The product is out of stock. Please select another one.');
            } else {
                $request->validate([
                    'order_quantity'            =>          ['required', 'numeric', 'min:1']
                ]);

                $orderQuantity = $request->order_quantity;

                if ($product->stock < $orderQuantity) {
                    return back()->with('error', 'You entered an excess amount.' . ' product stock ' . $product->stock);
                } else {
                    $order = Order::create([
                        'product_id'                =>          $request->product_id,
                        'order_quantity'            =>          $orderQuantity,
                        'status'                    =>          "Pending",
                        'user_id'                   =>          auth()->id()
                    ]);
                }

                $product->decrement('stock', $order->order_quantity);
                $product->increment('sold', $order->order_quantity);

                $productName = $product->product_name;

                $log_entry = Auth::user()->name . " has ordered product: " . $productName . " with the id# " . $product->id;
                event(new UserLog($log_entry));

                return redirect('/orders')->with('message', 'Ordered successfully');
            }
        } else {
            return redirect('/error')->with('error', 'Product not found. Please try again.');
        }
    }

    public function cancelled(Order $order)
    {
        $product = $order->product;
        $product->increment('stock', $order->order_quantity);
        $product->decrement('sold', $order->order_quantity);

        $order->delete();
        $productName = $product->product_name;

        $log_entry = Auth::user()->name . " has cancelled order: " . $productName . " with the id# " . $order->id;
        event(new UserLog($log_entry));

        return redirect('/orders')->with('message', 'Order cancelled successfully');
    }

    public function reviewRating(Order $order)
    {
        return view('normal-view.orders.review', compact('order'));
    }

    public function sendReviewRating(Request $request, Order $order)
    {
        $request->validate([
            'rating'            =>          ['required', 'numeric', 'min:1'],
            'comment'           =>          ['required']
        ]);

        $order->update([
            'rating'            =>          $request->rating,
            'comment'           =>          $request->comment,
            'status'            =>          "Paid"
        ]);

        $log_entry = Auth::user()->name . " rated: " . $order->rating . " star/s and giving review to " . $order->product->product_name . " and the status will automatically mark as PAID. with the id# " . $order->id;
        event(new UserLog($log_entry));

        return redirect('/orders')->with('message', 'Thank you for sending ' . $order->rating . ' star/s and review');
    }

    public function searchProduct(Request $request)
    {
        $search = $request->search;

        $products = Product::where('product_name', 'like', "%$search%")
            ->orWhere('brand_name', 'like', "%$search%")
            ->orWhere('price', 'like', "%$search%")
            ->orWhere('tracking_code', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%")
            ->orWhereHas('category', function ($categoryQuery) use ($search) {
                $categoryQuery->where('name', 'like', "%$search%");
            })
            ->get();

        return view('normal-view.pages.searched', compact('search', 'products'));
    }
}
