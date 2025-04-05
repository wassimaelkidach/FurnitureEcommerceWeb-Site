<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Color;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $colors = Color::all();
        return view('admin.products.create', compact('categories', 'colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'colors' => 'required|array',
            'colors.*' => 'exists:colors,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Main image
        $imagePath = $request->file('image')->store('products', 'public');
    
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);
    
        // Attach colors
        $product->colors()->attach($request->colors);
    
        // Additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $imagePath = $image->store('products/gallery', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }
        }
    
        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        $product = Product::with(['images', 'category', 'colors'])->findOrFail($id);
        $categories = Category::all();
        $colors = Color::all();
        return view('admin.products.edit', compact('product', 'categories', 'colors'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'colors' => 'required|array',
            'colors.*' => 'exists:colors,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $product = Product::findOrFail($id);
    
        // Update basic fields
        $product->update($validated);
    
        // Update main image
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
            $product->save();
        }
    
        // Update colors
        $product->colors()->sync($request->colors);
    
        // Update additional images
        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
    
            // Add new images
            foreach ($request->file('images') as $file) {
                $path = $file->store('products/gallery', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }
    
        return redirect()->route('admin.products.index')
                   ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);
        
        // Delete additional images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Delete main image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete product
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}