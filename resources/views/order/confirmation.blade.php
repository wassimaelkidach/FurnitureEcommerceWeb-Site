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

<!-- resources/views/orders/confirmation.blade.php -->
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
        
            
<div class="order-confirmation">
  <div class="confirmation-icon">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
      <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
    </svg>
  </div>
  
  <h1>Order Successful!</h1>
  
  
  
  <p class="confirmation-message">
    Thank you for your purchase! We've received your order and will process it shortly.
  </p>
  
  <div class="action-buttons">
    <a href="/" class="btn">Continue Shopping</a>
  </div>
</div>

<style>
  .order-confirmation {
    max-width: 500px;
    margin: 2rem auto;
    padding: 2rem;
    text-align: center;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  }
  
  .confirmation-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1.5rem;
    background: #4CAF50;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .confirmation-icon svg {
    width: 32px;
    height: 32px;
    color: white;
  }
  
  h1 {
    color: #333;
    margin-bottom: 0.5rem;
    font-size: 1.8rem;
  }
  
  .order-number {
    color: #666;
    margin-bottom: 2rem;
    font-size: 1rem;
  }
  
  .summary-box {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1.5rem;
    margin: 1.5rem 0;
    text-align: left;
  }
  
  .summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
  }
  
  .summary-row:last-child {
    margin-bottom: 0;
  }
  
  .summary-row span:first-child {
    color: #666;
  }
  
  .summary-row span:last-child {
    font-weight: 500;
  }
  
  .confirmation-message {
    color: #444;
    line-height: 1.6;
    margin: 1.5rem 0;
  }
  
  .action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
  }
  
  .btn {
    padding: 0.75rem 1.5rem;
    background: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 500;
    transition: background 0.2s;
  }
  
  .btn:hover {
    background: #3d8b40;
  }
  
  .btn.outline {
    background: transparent;
    border: 1px solid #4CAF50;
    color: #4CAF50;
  }
  
  .btn.outline:hover {
    background: #f0f9f0;
  }
</style>
@endsection