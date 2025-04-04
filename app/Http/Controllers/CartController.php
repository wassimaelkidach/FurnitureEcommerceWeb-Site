<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Address;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:products,id',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1|max:10',
            'price' => 'required|numeric|min:0'
        ]);

        try {
            Cart::instance('cart')->add(
                $request->id,
                $request->name,
                $request->quantity,
                $request->price
            )->associate('App\Models\Product');

            return redirect()->back()->with('success', 'Item added to cart successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add item to cart: '.$e->getMessage());
        }
    }

    public function increase_cart_quantity($rowId)
    {
        try {
            $product = Cart::instance('cart')->get($rowId);
            
            if (!$product) {
                throw new \Exception('Product not found in cart');
            }

            $qty = $product->qty + 1;
            Cart::instance('cart')->update($rowId, $qty);

            return redirect()->back()->with('success', 'Quantity increased');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function decrease_cart_quantity($rowId)
    {
        try {
            $product = Cart::instance('cart')->get($rowId);
            
            if (!$product) {
                throw new \Exception('Product not found in cart');
            }

            $qty = $product->qty - 1;
            
            if ($qty < 1) {
                $qty = 1;
            }

            Cart::instance('cart')->update($rowId, $qty);

            return redirect()->back()->with('success', 'Quantity decreased');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function remove_item($rowId)
    {
        try {
            $item = Cart::instance('cart')->get($rowId);
            
            if (!$item) {
                throw new \Exception("Item doesn't exist in cart");
            }

            Cart::instance('cart')->remove($rowId);

            return redirect()->back()->with([
                'success' => 'Item removed from cart',
                'cart_count' => Cart::instance('cart')->count()
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back()->with('success', 'Cart emptied successfully');
    }

   
    public function apply_coupon_code(Request $request)
    {
        $coupon_code = $request->coupon_code;
        
        if(isset($coupon_code))
        {
            $coupon = Coupon::where('code', $coupon_code)
                          ->where('expiry_date', '>=', Carbon::today())
                          ->where('cart_value', '<=', Cart::instance('cart')->subtotal())
                          ->first();
    
            if(!$coupon)
            {
                return redirect()->back()->with('error', 'Invalid coupon code!');
            }
            else
            {
                Session::put('coupon', [
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'cart_value' => $coupon->cart_value
                ]);
                
                $this->calculateDiscount();
                return redirect()->back()->with('success', 'Coupon has been applied');
            }
        }
        else
        {
            return redirect()->back()->with('error', 'Please enter a coupon code!');
        }
    }

   // In your CartController
   public function calculateDiscount()
   {
       $discount = 0;
       if(Session::has('coupon'))
       {
           if(Session::get('coupon')['type'] == 'fixed')
           {
               $discount = Session::get('coupon')['value'];
           }
           else
           {
               $discount = (Cart::instance('cart')->subtotal() * Session::get('coupon')['value'])/100;
           }
   
           $subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
           $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax'))/100;
           $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;
   
           Session::put('discounts', [
               'discount' => number_format(floatval($discount), 2, '.', ''),
               'subtotal' => number_format(floatval(Cart::instance('cart')->subtotal()), 2, '.', ''),
               'subtotal_after_discount' => number_format(floatval($subtotalAfterDiscount), 2, '.', ''),
               'tax' => number_format(floatval($taxAfterDiscount), 2, '.', ''),
               'total' => number_format(floatval($totalAfterDiscount), 2, '.', '')
           ]);
       }
   }
   public function remove_coupon_code()
{
    try {
        // Clear both coupon and discounts data
        Session::forget(['coupon', 'discounts']);
        
        // Optional: Recalculate cart totals without coupon
        $this->calculateDiscount();
        
        return redirect()
               ->back()
               ->with('success', 'Coupon has been removed successfully!');
    } catch (\Exception $e) {
        return redirect()
               ->back()
               ->with('error', 'Failed to remove coupon: '.$e->getMessage());
    }
}
public function checkout()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $address = Address::where('user_id', Auth::user()->id)
                     ->where('is_default', true)
                     ->first();

    return view('checkout', compact('address'));
}

}