@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9f9f9;
        color: #333;
    }

    main.pt-90 {
        padding-top: 90px;
        background-color: #fff;
    }

    .page-title {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 30px;
        color: #2c3e50;
    }

    .checkout-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .checkout-steps__item {
        flex: 1;
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background-color: #fafafa;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .checkout-steps__item.active {
        border-color: #3490dc;
        background-color: #e6f0ff;
        box-shadow: 0 2px 8px rgba(52, 144, 220, 0.1);
    }

    .checkout-steps__item-number {
        font-size: 20px;
        font-weight: bold;
        margin-right: 10px;
        color: #3490dc;
    }

    .checkout-steps__item-title span {
        font-weight: 600;
        display: block;
        color: #2c3e50;
    }

    .checkout-steps__item-title em {
        font-size: 13px;
        color: #7f8c8d;
    }

    .checkout-form {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
    }

    .billing-info__wrapper {
        flex: 1 1 60%;
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }

    .checkout__totals-wrapper {
        flex: 1 1 35%;
    }

    .checkout__totals {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        padding: 25px;
        margin-bottom: 25px;
    }

    .checkout__totals h3 {
        font-size: 22px;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
        color: #2c3e50;
        font-weight: 600;
    }

    .order-items-container {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 10px;
        margin-bottom: 20px;
    }

    .order-item {
        display: flex;
        align-items: flex-start;
        padding: 15px 0;
        border-bottom: 1px solid #f5f5f5;
        transition: all 0.3s ease;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item:hover {
        background-color: #fafafa;
    }

    .order-item-image {
        width: 80px;
        height: 80px;
        margin-right: 15px;
        flex-shrink: 0;
        border-radius: 6px;
        overflow: hidden;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .order-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .order-item-details {
        flex-grow: 1;
    }

    .order-item-name {
        font-weight: 600;
        margin-bottom: 5px;
        color: #2c3e50;
        font-size: 15px;
    }

    .order-item-info {
        font-size: 13px;
        color: #7f8c8d;
        margin-bottom: 3px;
    }

    .order-item-price {
        font-weight: 600;
        white-space: nowrap;
        margin-left: 15px;
        color: #2c3e50;
        font-size: 15px;
    }

    .checkout-totals {
        width: 100%;
        margin: 20px 0;
    }

    .checkout-totals th, 
    .checkout-totals td {
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
        text-align: left;
        color: #555;
    }

    .checkout-totals td {
        text-align: right;
        font-weight: 500;
    }

    .checkout-totals tr:last-child th,
    .checkout-totals tr:last-child td {
        border-bottom: none;
        padding-bottom: 5px;
    }

    .checkout-totals tr.total-row th,
    .checkout-totals tr.total-row td {
        padding-top: 15px;
        font-size: 16px;
        color: #2c3e50;
        font-weight: 600;
    }

    .checkout-totals tr.total-row th {
        border-top: 2px solid #f0f0f0;
    }

    .checkout-totals tr.total-row td {
        border-top: 2px solid #f0f0f0;
    }

    .checkout__payment-methods {
        background: #fff;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }

    .checkout__payment-methods h4 {
        font-size: 18px;
        margin-bottom: 20px;
        color: #2c3e50;
        font-weight: 600;
    }

    .form-check {
        margin-bottom: 20px;
        padding-left: 1.8rem;
    }

    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.2em;
    }

    .form-check-label {
        font-weight: 500;
        color: #2c3e50;
        cursor: pointer;
    }

    .option-detail {
        font-size: 13px;
        color: #7f8c8d;
        margin-top: 5px;
        padding-left: 1.8rem;
    }

    .policy-text {
        font-size: 13px;
        color: #7f8c8d;
        margin-top: 20px;
        line-height: 1.5;
    }

    .btn-checkout {
        display: block;
        width: 100%;
        padding: 14px;
        font-size: 16px;
        font-weight: bold;
        background-color: #3490dc;
        border: none;
        color: white;
        border-radius: 6px;
        margin-top: 20px;
        transition: background 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-checkout:hover {
        background-color: #227dc7;
    }

    .btn-save-address {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-top: 20px;
        font-size: 15px;
    }
    
    .btn-save-address:hover {
        background-color: #5a6268;
    }
    
    .address-feedback {
        margin-top: 10px;
        padding: 12px;
        border-radius: 6px;
        display: none;
        font-size: 14px;
    }
    
    .address-success {
        background-color: #d4edda;
        color: #155724;
    }
    
    .address-error {
        background-color: #f8d7da;
        color: #721c24;
    }

    .form-floating {
        position: relative;
        margin-bottom: 1rem;
    }

    .form-floating label {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        padding: 1rem 0.75rem;
        pointer-events: none;
        border: 1px solid transparent;
        transform-origin: 0 0;
        transition: opacity .1s ease-in-out, transform .1s ease-in-out;
        color: #7f8c8d;
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label,
    .form-floating > .form-select ~ label {
        transform: scale(.85) translateY(-0.8rem) translateX(0.15rem);
        opacity: .8;
        background: #fff;
        padding: 0 5px;
    }

    .form-control {
        padding: 1rem 0.75rem;
        border-radius: 6px;
        border: 1px solid #ddd;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #3490dc;
        box-shadow: 0 0 0 0.25rem rgba(52, 144, 220, 0.25);
    }

    .text-danger {
        font-size: 13px;
        margin-top: 5px;
        display: block;
    }

    /* Custom scrollbar */
    .order-items-container::-webkit-scrollbar {
        width: 6px;
    }

    .order-items-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .order-items-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .order-items-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    @media (max-width: 768px) {
        .checkout-form {
            flex-direction: column;
        }

        .billing-info__wrapper,
        .checkout__totals-wrapper {
            flex: 1 1 100%;
        }

        .checkout-steps {
            flex-direction: column;
        }

        .checkout-steps__item {
            margin-bottom: 10px;
        }

        .order-item-image {
            width: 60px;
            height: 60px;
        }
    }
</style>

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Shipping and Checkout</h2>
        <div class="checkout-steps">
            <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Shopping Bag</span>
                    <em>Manage Your Items List</em>
                </span>
            </a>
            <a href="{{ route('cart.checkout') }}" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Shipping and Checkout</span>
                    <em>Checkout Your Items List</em>
                </span>
            </a>
            <a href="#" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Review And Submit Your Order</em>
                </span>
            </a>
        </div>
        
        <div class="checkout-form">
            <div class="billing-info__wrapper">
                <div class="row">
                    <div class="col-12">
                        <h4><i class="fas fa-truck me-2"></i> SHIPPING DETAILS</h4>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="name" id="name" required 
                                   value="{{ old('name', auth()->user()->name ?? '') }}" placeholder="Full Name">
                            <label for="name">Full Name *</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="phone" id="phone" required 
                                   value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="Phone Number">
                            <label for="phone">Phone Number *</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="zip" id="zip" required 
                                   value="{{ old('zip') }}" placeholder="Pincode">
                            <label for="zip">Pincode *</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mt-3 mb-3">
                            <input type="text" class="form-control" name="state" id="state" required 
                                   value="{{ old('state') }}" placeholder="State">
                            <label for="state">State *</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="city" id="city" required 
                                   value="{{ old('city') }}" placeholder="Town / City">
                            <label for="city">Town / City *</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="address" id="address" required 
                                   value="{{ old('address') }}" placeholder="House no, Building Name">
                            <label for="address">House no, Building Name *</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="locality" id="locality" required 
                                   value="{{ old('locality') }}" placeholder="Road Name, Area, Colony">
                            <label for="locality">Road Name, Area, Colony *</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="landmark" id="landmark" 
                                   value="{{ old('landmark') }}" placeholder="Landmark (Optional)">
                            <label for="landmark">Landmark (Optional)</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating my-3">
                            <select class="form-control" name="type" id="type">
                                <option value="home" {{ old('type') == 'home' ? 'selected' : '' }}>Home</option>
                                <option value="office" {{ old('type') == 'office' ? 'selected' : '' }}>Office</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <label for="type">Address Type</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="button" id="save-address-btn" class="btn btn-save-address">
                            <i class="fas fa-save me-2"></i>Save Address
                        </button>
                        <div id="address-feedback" class="address-feedback"></div>
                    </div>
                </div>
            </div>
            
            <div class="checkout__totals-wrapper">
                <div class="sticky-content">
                    <div class="checkout__totals">
                        <h3><i class="fas fa-shopping-bag me-2"></i> Your Order</h3>
                
                        <div class="order-items-container">
                            @foreach($cartItems as $item)
                            <div class="order-item">
                                <div class="order-item-image">
                                    @if($item->product->image && Storage::disk('public')->exists('products/'.basename($item->product->image)))
                                        <img src="{{ asset('storage/products/' . basename($item->product->image)) }}" 
                                             alt="{{ $item->product->name }}">
                                    @else
                                        <i class="fas fa-image text-muted"></i>
                                    @endif
                                </div>
                                <div class="order-item-details">
                                    <div class="order-item-name">{{ $item->product->name }}</div>
                                    @if($item->color)
                                        <div class="order-item-info">
                                            <i class="fas fa-palette me-1"></i> Color: {{ $item->color }}
                                        </div>
                                    @endif
                                    <div class="order-item-info">
                                        <i class="fas fa-layer-group me-1"></i> Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                    </div>
                                </div>
                                <div class="order-item-price">${{ number_format($item->price * $item->quantity, 2) }}</div>
                            </div>
                            @endforeach
                        </div>
                        
                        <table class="checkout-totals">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>${{ number_format($subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping</th>
                                    <td>${{ number_format($shipping ?? 10.00, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>VAT</th>
                                    <td>${{ number_format($vat, 2) }}</td>
                                </tr>
                                <tr class="total-row">
                                    <th>Total</th>
                                    <td>${{ number_format($total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="checkout__payment-methods">
                        <h4><i class="fas fa-credit-card me-2"></i> PAYMENT METHOD</h4>
                        
                        <!-- Stripe Payment Option -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                   id="payment_stripe" value="stripe" required checked>
                            <label class="form-check-label" for="payment_stripe">
                                Credit/Debit Card (Stripe)
                            </label>
                            <div class="option-detail ps-4 mt-2">
                                <div class="d-flex gap-2 mb-2">
                                    <img src="{{ asset('images/visa-icon-256x164-2h8ja9is.png') }}" alt="Visa" style="height: 24px;">
                                    <img src="{{ asset('images/pngimg.com - mastercard_PNG23.png') }}" alt="Mastercard" style="height: 24px;">
                                </div>
                                <div id="stripe-payment" class="mt-3">
                                    <button type="button" id="stripe-checkout-button" class="btn btn-primary btn-checkout">
                                        <i class="fas fa-credit-card me-2"></i> Pay with Stripe
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PayPal Payment Option -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                   id="payment_paypal" value="paypal">
                            <label class="form-check-label" for="payment_paypal">
                                PayPal
                            </label>
                            <div class="option-detail ps-4">
                                <p>You'll be redirected to PayPal to complete your payment</p>
                                <div id="paypal-button-container" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="policy-text mt-3">
                            <i class="fas fa-lock me-2"></i> Your payment is secure. Your personal information is protected with industry-standard encryption.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@push('scripts')


</script>
@endpush

@endsection