@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pb-0">
                    <h2 class="h4">Shopping Bag</h2>
                    <p class="text-muted small">Manage Your Items List</p>
                </div>
                
                <div class="card-body px-0">
                    @foreach($cartItems as $item)
                    <div class="row align-items-center mb-4 pb-3 border-bottom mx-0">
                        <div class="col-3 col-md-2 px-0">
                            @if($item->product->image && Storage::disk('public')->exists('products/'.basename($item->product->image)))
                                <img src="{{ asset('storage/products/' . basename($item->product->image)) }}" 
                                     class="img-fluid rounded" 
                                     style="height: 80px; width: 100%; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                     style="height: 80px; width: 100%;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-9 col-md-10 ps-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">{{ $item->product->name }}</h5>
                                    <p class="mb-1 small">
    <span class="text-muted">Color:</span> 
    <span class="fw-medium">{{ $item->color }}</span>
</p>

                                </div>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="quantity-control d-flex align-items-center">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="change" value="-1" 
                                                class="btn btn-outline-secondary btn-sm px-3 py-1">
                                            -
                                        </button>
                                        <span class="mx-2">{{ $item->quantity }}</span>
                                        <button type="submit" name="change" value="1" 
                                                class="btn btn-outline-secondary btn-sm px-3 py-1">
                                            +
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="text-end">
                                    <p class="mb-0 fw-bold">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                    <small class="text-muted">${{ number_format($item->price, 2) }} each</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h2 class="h4">Cart Totals</h2>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('cart.applyCoupon') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="coupon_code" class="form-control" placeholder="Coupon">
                            <button class="btn btn-outline-dark" type="submit">APPLY COUPON</button>
                        </div>
                    </form>
                    
                    <table class="table table-borderless">
                        <tr>
                            <td class="ps-0">Subtotal</td>
                            <td class="text-end pe-0">${{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="ps-0">Shipping</td>
                            <td class="text-end pe-0">Free</td>
                        </tr>
                        <tr>
                            <td class="ps-0">VAT (19%)</td>
                            <td class="text-end pe-0">${{ number_format($vat, 2) }}</td>
                        </tr>
                        <tr class="border-top">
                            <td class="ps-0 fw-bold">Total</td>
                            <td class="text-end pe-0 fw-bold">${{ number_format($total, 2) }}</td>
                        </tr>
                    </table>
                    
                    <a href="#" class="btn btn-dark w-100 py-3">PROCEED TO CHECKOUT</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .quantity-control button {
        min-width: 30px;
        text-align: center;
    }
    .card-header {
        padding: 1.25rem 1.25rem 0;
    }
    .border-bottom-0 {
        border-bottom: none !important;
    }
</style>
@endsection