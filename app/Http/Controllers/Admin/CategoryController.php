<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserLog;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function categories()
    {
        $categories = Category::orderBy('created_at', 'asc')->paginate(10);
        return view('admin.products.category', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.products.create-category');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'                      =>          ['required', 'max:255', 'unique:categories,name'],
            'remarks'                   =>          ['required'],
            'cat_image'                =>          ['required', 'max:10000']
        ]);

        if ($request->hasFile('cat_image')) {
            $image = $request->file('cat_image');

            $imageFileName = Str::random(20) . '.' . $image->getClientOriginalExtension();

            $image->storeAs('images/category_pictures', $imageFileName, 'public');

            $imagePath = 'images/category_pictures/' . $imageFileName;
        }

        $category = Category::create([
            'cat_image'    =>              $imagePath,
            'name'          =>              $request->name,
            'remarks'       =>              $request->remarks
        ]);

        $log_entry = Auth::user()->name . " added a new category name: " . $category->name . " with the id# " . $category->id;
        event(new UserLog($log_entry));
        return redirect('admin/categories')->with('message', 'Category added successfully.');
    }

    public function updateCategory(Category $category)
    {
        return view('admin.products.edit-category', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'          =>          ['required', 'max:255', 'unique:categories,name->ignore($request->category->id)'],
            'remarks'       =>          ['required']
        ]);


        $imagePath = $category->cat_image;

        if ($request->hasFile('cat_image')) {
            $image = $request->file('cat_image');

            $imageFileName = Str::random(20) . '.' . $image->getClientOriginalExtension();

            $image->storeAs('images/product_pictures', $imageFileName, 'public');

            $imagePath = 'images/product_pictures/' . $imageFileName;

            if ($category->cat_image && !Str::contains($category->cat_image, '3237155-200.png')) {
                Storage::disk('public')->delete($category->cat_image);
            }
        }

        $category->update([
            'cat_image'    =>              $imagePath,
            'name'          =>              $request->name,
            'remarks'       =>              $request->remarks
        ]);

        $log_entry = Auth::user()->name . " updated an category name: " . $category->name . " with the id# " . $category->id;
        event(new UserLog($log_entry));
        return redirect('admin/categories')->with('message', 'Category updated successfully.');
    }

    public function delete(Category $category)
    {

        $log_entry = Auth::user()->name . " deleted the category name: " . $category->name . " with the id# " . $category->id;
        event(new UserLog($log_entry));
        $category->delete();
        return redirect('admin/categories')->with('message', 'Category deleted successfully.');
    }

    public function searchCategory(Request $request)
    {
        $search = $request->search;

        $categories = Category::where(function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('remarks', 'like', "%$search%");
        })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.products.category-searched', compact('categories', 'search'));
    }
}
