<?php

// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    // Afficher le panier pour un utilisateur spécifique
    public function index(): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir votre panier.');
        }

        $userId = Auth::id();
        $cart = session()->get('cart_' . $userId, []);

        if (empty($cart)) {
            $totalPrice = 0;
            $totalItems = 0;
        } else {
            // Calculer le prix total et le nombre d'articles
            $totalPrice = 0;
            $totalItems = 0;

            foreach ($cart as $productId => $product) {
                $totalPrice += $product['quantity'] * $product['price'];
                $totalItems += $product['quantity'];
            }
        }

        // Récupérer des produits aléatoires pour suggérer à l'utilisateur
        $randomProducts = Product::inRandomOrder()->limit(4)->get();

        return view('cart.index', compact('cart', 'totalPrice', 'totalItems', 'randomProducts'));
    }

    // Ajouter un produit au panier
    public function add(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour ajouter des produits au panier.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $userId = Auth::id();
        $cart = Session::get('cart_' . $userId, []);

        // Vérification si le produit existe déjà dans le panier
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'image' => $product->image
            ];
        }

        // Mise à jour du panier en session
        Session::put('cart_' . $userId, $cart);

        return redirect()->back()->with('success', 'Produit ajouté au panier !');
    }

    // Mettre à jour les quantités des produits dans le panier
    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour modifier votre panier.');
        }

        $userId = Auth::id();
        $cart = session()->get('cart_' . $userId, []);

        foreach ($request->quantities as $productId => $quantity) {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
            }
        }

        session()->put('cart_' . $userId, $cart);

        return redirect()->route('cart.index')->with('success', 'Panier mis à jour');
    }

    // Retirer un produit du panier
    public function remove(Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour supprimer un produit de votre panier.');
        }

        $userId = Auth::id();
        $cart = session()->get('cart_' . $userId, []);

        unset($cart[$product->id]);
        session()->put('cart_' . $userId, $cart);

        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier');
    }
}