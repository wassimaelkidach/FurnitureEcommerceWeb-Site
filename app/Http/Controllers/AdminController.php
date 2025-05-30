<?php

namespace App\Http\Controllers;
use App\Models\Coupon;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\User;          
use App\Models\Product;       
use App\Models\Payment;       
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
    $stats = [
        'users' => User::count(),
        'products' => Product::count(),
        'pending_orders' => Order::where('status', 'pending')->count(),
        'completed_payments' => Payment::where('status', 'completed')->count()
    ];

    $recentOrders = Order::with('payment')
                        ->latest()
                        ->take(5)
                        ->get();

    $recentPayments = Payment::with('order')
                            ->where('status', 'completed')
                            ->latest()
                            ->take(5)
                            ->get();

    return view('admin.dashboard', compact('stats', 'recentOrders', 'recentPayments'));
    }


    public function coupons(Request $request)
{
    $query = Coupon::query()
        ->when($request->status === 'expired', fn($q) => $q->where('expiry_date', '<', now()))
        ->when($request->status === 'active', fn($q) => $q->where('expiry_date', '>=', now()))
        ->orderBy('expiry_date', 'DESC');

    return view('admin.coupons', [
        'coupons' => $query->paginate(12)->withQueryString(),
        'status' => $request->status
    ]);
}

public function coupon_add()
{
    return view('admin.coupon-add');
}

public function coupon_store(Request $request)
{
    $request->validate([
    'code' => 'required',
    'type' => 'required',
    'value' => 'required|numeric',
    'cart_value' => 'required|numeric',
    'expiry_date' => 'required|date'
    ]);
    $coupon = new Coupon();
    $coupon->code = $request->code;
    $coupon->type = $request->type;
    $coupon->value = $request->value;
    $coupon->cart_value = $request->cart_value;
    $coupon->expiry_date = $request->expiry_date;
    $coupon->save();
    return redirect()->route('admin.coupons')->with('status','Coupon has been added successfully!');

}
public function edit($id)
{
    $coupon = Coupon::findOrFail($id);
    $couponTypes = ['fixed' => 'Fixed', 'percent' => 'Percent'];
    
    return view('admin.coupon-edit', compact('coupon', 'couponTypes'));
}
 public function coupon_update(Request $request)
{
    $request->validate([
    'code' => 'required',
    'type' => 'required',
    'value' => 'required|numeric',
    'cart_value' => 'required|numeric',
    'expiry_date' => 'required|date'
    ]);
    $coupon = Coupon::find($request->id);
    $coupon->code = $request->code;
    $coupon->type = $request->type;
    $coupon->value = $request->value;
    $coupon->cart_value = $request->cart_value;
    $coupon->expiry_date = $request->expiry_date;
    $coupon->save();
    return redirect()->route('admin.coupons')->with('status','Coupon has been updated successfully!');
}

public function coupon_delete($id)
{
    $coupon = Coupon::find($id);
    $coupon->delete();
    return redirect()->route('admin.coupons')->with('status','Coupon has been deleted successfully!');
}

public function orders()
{
    $orders = Order::orderBy('created_at','DESC')->paginate(12);
    return view('admin.orders',compact('orders'));
} 
}