<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $premiumProducts = Product::orderBy('price', 'DESC')->take(8)->get(); // 8 produits les plus chers
        
        return view('layouts.home', compact('categories', 'premiumProducts'));
    }
}