<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Color;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'colors'])->get();
        $categories = Category::all();
        $colors = Color::all();
        
        return view('product.index', compact('products', 'categories', 'colors'));
    }
    
    public function productsByCategory($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products()->with(['category', 'colors'])->get();
        
        return view('category.products', compact('category', 'products'));
    }

    public function show($id)
    {
    $product = Product::with(['category', 'colors', 'reviews', 'images'])->findOrFail($id);
    return view('product.show', compact('product'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (empty($query)) {
            return redirect()->back()->with('error', 'Veuillez entrer un terme de recherche');
        }
    
        $products = Product::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->with('category')
            ->paginate(10);
    
        return view('product.search', compact('products', 'query'));
    }
}