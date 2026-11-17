<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
{
    // Category List
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15);

        return view('backend.admin-dashboard.product_categories.index', compact('categories'));
    }

    // Create Form
    public function create()
    {
        return view('backend.admin-dashboard.product_categories.create');
    }

    // Store Category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150|unique:categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|string',
        ]);

        $validated['slug'] = Str::of($validated['name'])
            ->trim()
            ->replaceMatches('/\s+/u', '-')
            ->replaceMatches('/-+/u', '-')
            ->toString();



        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = fileUpload($request->file('image'), 'uploads/products');
        }

        if ($request->hasFile('image')) {
            $validated['image'] = fileUpload($request->file('image'), 'uploads/products-categories');
             
        }

        $validated['status'] = $request->string('status');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Category::create($validated);

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'পণ্যের ক্যাটাগরি সফলভাবে তৈরি হয়েছে।');
    }

    // Edit Form
    public function edit(Category $productCategory)
    {
        return view('backend.admin-dashboard.product_categories.edit', compact('productCategory'));
    }

    // Update Category
    public function update(Request $request, Category $productCategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('categories', 'name')
                    ->ignore($productCategory->id),
            ],


            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|string',
        ]);


        $validated['slug'] = Str::of($validated['name'])
            ->trim()
            ->replaceMatches('/\s+/u', '-')
            ->replaceMatches('/-+/u', '-')
            ->toString();

 

   

        if ($request->hasFile('image')) {

            if ($productCategory->image) {

                $oldImage = base_path($productCategory->image);

                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            $validated['image'] = fileUpload(
                $request->file('image'),
                'uploads/products-categories'
            );
        }

        $validated['status'] = $validated['status'];
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
 
        $productCategory->update($validated);

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'ক্যাটাগরি সফলভাবে আপডেট হয়েছে।');
    }

    // Delete Category
    public function destroy(Category $productCategory)
    {
        // এই ক্যাটাগরিতে পণ্য থাকলে Delete হবে না
        if ($productCategory->products()->exists()) {
            return back()->with(
                'error',
                'এই ক্যাটাগরিতে পণ্য রয়েছে। আগে পণ্যগুলোর ক্যাটাগরি পরিবর্তন করুন।'
            );
        }

        if ($productCategory->image) {
            Storage::disk('public')->delete($productCategory->image);
        }

        $productCategory->delete();

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'ক্যাটাগরি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
