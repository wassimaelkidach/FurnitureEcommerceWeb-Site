<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    public function index()
    {
        $payments = Payment::with('order')->latest()->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $orders = Order::where('status', '!=', 'cancelled')->get();
        return view('admin.payments.edit', compact('payment', 'orders'));
    }

    public function store(Request $request)

    {
    $validated = $request->validate([
        'order_id' => 'required|exists:orders,id',
        'amount' => 'required|numeric|min:0',
        'payment_method' => 'required|string',
        'transaction_id' => 'required|string',
        'status' => 'required|in:pending,completed,failed,refunded',
        'notes' => 'nullable|string'
    ]);

    $payment = Payment::create($validated);

    return redirect()->route('admin.payments.show', $payment)
                     ->with('success', 'Paiement enregistré avec succès');

    }


    public function update(Request $request, Payment $payment)

    {
    $validated = $request->validate([
        'status' => 'required|in:pending,completed,failed,refunded',
        'notes' => 'nullable|string'
    ]);

    $payment->update($validated);

    return redirect()->route('admin.payments.index')
                     ->with('success', 'Paiement mis à jour avec succès');

    }
}
