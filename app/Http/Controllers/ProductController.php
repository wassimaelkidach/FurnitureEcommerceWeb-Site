<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Récupérer tous les produits
        $products = Product::all();

        // Passer les produits à la vue
        return view('product.index', compact('products'));
    }
    
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



    public function search(Request $request)
    {
        // Récupérer le terme de recherche
        $query = $request->input('query');
        
        // Vérifier si la recherche est vide
        if ($query) {
            // Recherche les produits qui correspondent à la recherche
            $searchedProducts = Product::where('name', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->get();
        } else {
            // Si aucune recherche n'est effectuée, ne renvoie aucun produit
            $searchedProducts = collect(); // collection vide
        }

        // Retourner la vue avec les produits trouvés ou une collection vide
        return view('products.index', ['searchedProducts' => $searchedProducts]);
    }
}



