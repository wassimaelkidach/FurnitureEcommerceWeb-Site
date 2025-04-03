<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')
               ->with('success', 'Catégorie ajoutée avec succès.');
    }

    public function index()
    {
        $categories = Category::withCount('products')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category->name = $request->name;

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::delete('public/' . $category->image);
            }
            $category->image = $request->file('image')->store('categories', 'public');
        }

        $category->save();

        return redirect()->route('admin.categories.index')
               ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->image) {
            Storage::delete('public/' . $category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
               ->with('success', 'Catégorie supprimée avec succès.');
    }
}