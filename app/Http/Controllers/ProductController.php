<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Afficher les produits associés à une catégorie
    public function productsByCategory($id)
    {
        // Récupérer la catégorie
        $category = Category::findOrFail($id);
        
        // Récupérer les produits associés à la catégorie
        $products = $category->products;
        
        // Passer la catégorie et les produits à la vue
        return view('category.products', compact('category', 'products'));
    }
    public function show($id)
{
    $product = Product::findOrFail($id);
    return view('product.show', compact('product'));
}

}
