<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserLog;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function searchProduct(Request $request)
    {
        $search = $request->search;

        $products = Product::with('category')
            ->where(function ($query) use ($search) {
                $query->where('tracking_code', 'like', "%$search%")
                    ->orWhere('product_name', 'like', "%$search%")
                    ->orWhere('price', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            })
            ->orWhereHas('category', function ($categoryQuery) use ($search) {
                $categoryQuery->where('name', 'like', "%$search%")
                    ->orWhere('remarks', 'like', "%$search%");
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.products.searched', compact('products', 'search'));
    }

    public function index(Product $product)
    {
        $products = Product::orderBy('created_at', 'asc')->with('category')->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_image'            =>          ['required', 'max:10000'],
            'product_name'             =>          ['required'],
            'brand_name'               =>          ['required'],
            'stock'                    =>          ['required', 'numeric', 'min:1'],
            'price'                    =>          ['required', 'numeric', 'min:1'],
            'description'              =>          ['required'],
            'category_id'              =>          ['required']
        ]);

        $productImages = [];

        if ($request->hasFile('product_image')) {
            foreach ($request->file('product_image') as $productImg) {
                $imageFileName = Str::random(20) . '.' . $productImg->getClientOriginalExtension();
                $productImg->storeAs('images/product_pictures', $imageFileName, 'public');
                $productImages[] = 'images/product_pictures/' . $imageFileName;
            }
        }

        $tracking_code = Str::random(6);

        $product = Product::create([
            'tracking_code'            =>          $tracking_code,
            'product_image'            =>          $productImages,
            'product_name'             =>          $request->product_name,
            'brand_name'               =>          $request->brand_name,
            'stock'                    =>          $request->stock,
            'price'                    =>          $request->price,
            'description'              =>          $request->description,
            'category_id'              =>          $request->category_id
        ]);

        $log_entry = Auth::user()->name . " added a new product: " . $product->product_name . " with the id# " . $product->id;
        event(new UserLog($log_entry));

        return redirect('/admin/products')->with('message', 'Product detail added successfully');
    }

    public function updateProduct(Product $product)
    {

        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_image'            =>          ['max:10000'],
            'product_name'             =>          ['required'],
            'brand_name'               =>          ['required'],
            'stock'                    =>          ['required', 'numeric', 'min:1'],
            'price'                    =>          ['required', 'numeric', 'min:1'],
            'description'              =>          ['required'],
            'category_id'              =>          ['required']
        ]);

        $productImages = $product->product_image;

        if ($request->hasFile('product_image')) {

            $newProductImages = [];
            foreach ($request->file('product_image') as $productImg) {
                $imageFileName = Str::random(20) . '.' . $productImg->getClientOriginalExtension();
                $productImg->storeAs('images/product_pictures', $imageFileName, 'public');
                $newProductImages[] = 'images/product_pictures/' . $imageFileName;
            }

            if (!empty($product->product_image)) {
                foreach ($product->product_image as $existingImage) {
                    if (!Str::contains($existingImage, 'no-image.png')) {
                        Storage::disk('public')->delete($existingImage);
                    }
                }
            }

            $productImages = $newProductImages;
        }

        $product->update([
            'product_image'            =>          $productImages,
            'product_name'             =>          $request->product_name,
            'brand_name'               =>          $request->brand_name,
            'stock'                    =>          $request->stock,
            'price'                    =>          $request->price,
            'description'              =>          $request->description,
            'category_id'              =>          $request->category_id
        ]);

        $log_entry = Auth::user()->name . " updated the product: " . $product->product_name . " with the id# " . $product->id;
        event(new UserLog($log_entry));

        return redirect('/admin/products')->with('message', 'Product updated successfully');
    }

    public function delete(Product $product)
    {
        $log_entry = Auth::user()->name . " deleted the product " . $product->product_name .  " with the id# " . $product->id;
        event(new UserLog($log_entry));

        if (!empty($product->product_image)) {
            foreach ($product->product_image as $existingImage) {
                if (!Str::contains($existingImage, 'no-image.png')) {
                    Storage::disk('public')->delete($existingImage);
                }
            }
        }

        $product->delete();

        return redirect('/admin/products')->with('message', 'Product detail deleted successfully');
    }
}
