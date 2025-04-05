<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\User;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $discount = 0;
        $coupon = session('coupon');

        if ($coupon) {
            $discount = $coupon['type'] == 'fixed' 
                ? $coupon['value'] 
                : ($subtotal * $coupon['value']) / 100;
        }

        $subtotalAfterDiscount = $subtotal - $discount;
        $vat = $subtotalAfterDiscount * 0.19; // 19% VAT
        $total = $subtotalAfterDiscount + $vat;

        return view('cart.index', compact(
            'cartItems',
            'subtotal',
            'discount',
            'subtotalAfterDiscount',
            'vat',
            'total',
            'coupon'
        ));
    }

    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'color' => 'required',
            'quantity' => 'required|numeric|min:1'
        ]);
     

        CartItem::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'color' => $request->color,
            ],
            [
                'quantity' => $request->quantity,
                'price' => $product->price
            ]
        );

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function removeFromCart(CartItem $cartItem)
    {
        $cartItem->delete();
        return back()->with('success', 'Item removed from cart');
    }

    public function clearCart()
    {
        CartItem::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Cart cleared');
    }

    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('expiry_date', '>=', now())
            ->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid coupon code');
        }

        session(['coupon' => [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value
        ]]);

        return back()->with('success', 'Coupon applied successfully');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed');
    }

    // Ajoutez cette méthode dans votre CartController
public function updateQuantity(Request $request, CartItem $cartItem)
{
    $request->validate([
        'change' => 'required|in:-1,1'
    ]);

    $newQuantity = $cartItem->quantity + $request->change;

    // Empêcher la quantité d'être inférieure à 1
    if ($newQuantity < 1) {
        return back()->with('error', 'Quantity cannot be less than 1');
    }

    $cartItem->update(['quantity' => $newQuantity]);

    return back()->with('success', 'Quantity updated');
}

public function checkout()
{

    // Récupérer les produits du panier de l'utilisateur connecté
    $cartItems = CartItem::with(['product', 'color'])
    ->where('user_id', Auth::id())
    ->get();
    $subtotal = $cartItems->sum(function ($item) {
        return $item->price * $item->quantity;
    });

    $shipping = 10.00;
    $vat = $subtotal * 0.2; // TVA de 20%
    $total = $subtotal + $shipping + $vat;

    return view('checkout', compact('cartItems', 'subtotal', 'shipping', 'vat', 'total'));
}

}