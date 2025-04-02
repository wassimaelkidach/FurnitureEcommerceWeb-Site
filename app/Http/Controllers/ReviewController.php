<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $user = Auth::user();

if (!$user) {
    return redirect()->route('login')->with('error', 'Vous devez être connecté pour laisser un avis.');
}

Review::create([
    'user_id' => $user->id,  // Utilisation de l'objet User directement
    'product_id' => $product->id,
    'rating' => $request->rating,
    'comment' => $request->comment,
]);

    
        return redirect()->back()->with('success', 'Votre avis a été ajouté !');
    }
    
}
