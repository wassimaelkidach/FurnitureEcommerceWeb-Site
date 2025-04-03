<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller {
    public function index() {
        // Récupérer les favoris de l'utilisateur
        $favorites = Favorite::where('user_id', Auth::id())->with('product')->get();

        // Récupérer des produits aléatoires qui ne sont pas encore dans les favoris de l'utilisateur
        $randomProducts = Product::whereNotIn('id', $favorites->pluck('product_id'))
                                  ->inRandomOrder()
                                  ->limit(3) // Afficher 3 produits random
                                  ->get();

        // Passer les données à la vue
        return view('favorites.index', compact('favorites', 'randomProducts'));
    }

    public function store($id) {
        $product = Product::findOrFail($id);

        if (!Favorite::where('user_id', Auth::id())->where('product_id', $id)->exists()) {
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté aux favoris.');
    }

    public function destroy($id) {
        $favorite = Favorite::where('user_id', Auth::id())->where('product_id', $id)->firstOrFail();
        $favorite->delete();

        return redirect()->back()->with('success', 'Produit retiré des favoris.');
    }
}