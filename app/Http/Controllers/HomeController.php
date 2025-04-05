<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer toutes les catégories
        $categories = Category::all();
        
        // Récupérer 6 produits aléatoires
        $randomProducts = Product::inRandomOrder()->limit(6)->get();

        // Retourner la vue avec les variables 'categories' et 'randomProducts'
        return view('layouts.home', compact('categories', 'randomProducts'));
    }
}
