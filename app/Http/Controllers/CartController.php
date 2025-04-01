<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{

    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier.');
    }
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return redirect()->route('cart.index')->with('error', 'Accès refusé.');
        }
    
        $cart->update(['quantity' => $request->quantity]);
    
        return redirect()->route('cart.index')->with('success', 'Panier mis à jour.');
    }
    

    public function destroy($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', 'Produit supprimé du panier.');
    }
}
