<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use Srmklive\PayPal\Services\PayPal;

class PayPalController extends Controller
{
    public function processPayment(Request $request)
    {
        $user = Auth::user();
        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        $shipping = 10;
        $tax = $subtotal * 0.08;
        $total = $subtotal + $shipping + $tax;

        // Store order data in session
        session([
            'order_data' => [
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'discount' => 0,
                'tax' => $tax,
                'total' => $total,
                'name' => $request->name,
                'phone' => $request->phone,
                'locality' => $request->locality,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country ?? 'United States',
                'landmark' => $request->landmark,
                'zip' => $request->zip,
                'type' => $request->type ?? 'home',
                'payment_method' => 'paypal',
                'payment_status' => 'pending',
                'status' => 'ordered',
                'cart_items' => $cartItems->map(function($item) {
                    return [
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price
                    ];
                })->toArray()
            ]
        ]);

        $provider = new PayPal;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
                "brand_name" => config('app.name'),
                "user_action" => "PAY_NOW"
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => number_format($total, 2),
                        "breakdown" => [
                            "item_total" => [
                                "currency_code" => "USD",
                                "value" => number_format($subtotal, 2)
                            ],
                            "shipping" => [
                                "currency_code" => "USD",
                                "value" => number_format($shipping, 2)
                            ],
                            "tax_total" => [
                                "currency_code" => "USD",
                                "value" => number_format($tax, 2)
                            ]
                        ]
                    ],
                    "description" => "Order from " . config('app.name'),
                    "items" => $cartItems->map(function ($item) {
                        return [
                            "name" => $item->product->name,
                            "unit_amount" => [
                                "currency_code" => "USD",
                                "value" => number_format($item->product->price, 2)
                            ],
                            "quantity" => $item->quantity,
                            "category" => "PHYSICAL_GOODS"
                        ];
                    })->toArray()
                ]
            ]
        ]);
        
        if (isset($response['id']) && $response['id'] != null) {
            session(['paypal_transaction_id' => $response['id']]);
            
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }
        
        return redirect()->route('payment.error')
            ->with('error', 'Something went wrong with PayPal');
    }
    
    public function handleSuccess(Request $request)
    {
        $provider = new PayPal;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        
        $paypalOrderId = session('paypal_transaction_id');
        $orderData = session('order_data');
        
        if (empty($paypalOrderId) || empty($orderData)) {
            return redirect()->route('cart.index')
                ->with('error', 'Session data missing');
        }
    
        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $order = Order::create([
                'user_id' => $orderData['user_id'],
                'subtotal' => $orderData['subtotal'],
                'discount' => $orderData['discount'],
                'tax' => $orderData['tax'],
                'total' => $orderData['total'],
                'name' => $orderData['name'],
                'phone' => $orderData['phone'],
                'locality' => $orderData['locality'],
                'address' => $orderData['address'],
                'city' => $orderData['city'],
                'state' => $orderData['state'],
                'country' => $orderData['country'],
                'landmark' => $orderData['landmark'],
                'zip' => $orderData['zip'],
                'type' => $orderData['type'],
                'payment_method' => 'paypal',
                'payment_status' => 'completed',
                'transaction_id' => $response['id'],
                'payment_details' => json_encode($response),
                'status' => 'ordered'
            ]);
    
            foreach ($orderData['cart_items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }
    
            CartItem::where('user_id', $orderData['user_id'])->delete();
            session()->forget(['paypal_transaction_id', 'order_data']);
    
            return redirect()->route('order.confirmation', ['order' => $order->id])
                ->with('success', 'Payment completed successfully!');
        }
        
        return redirect()->route('payment.error')
            ->with('error', 'Payment failed or could not be verified');
    }
    
    public function handleCancel()
    {
        session()->forget(['paypal_transaction_id', 'order_data']);
        return redirect()->route('payment.cancel')
            ->with('error', 'Payment was cancelled');
    }
}