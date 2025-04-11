@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8fafc;
        color: #334155;
        line-height: 1.6;
        margin: 0;
    }

    main {
        background-color: #fff;
    }

    .page-title {
        margin-bottom: 30px;
        color: #2c3e50;
    }
    
    .container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
        min-height: 60vh;
    }

    /* Checkout Steps */
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
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

    /* Checkout Layout */
    .checkout-form {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
    }

    .billing-info__wrapper {
        flex: 1 1 60%;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .checkout__totals-wrapper {
        flex: 1 1 35%;
    }

    .checkout__totals {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 30px;
        margin-bottom: 25px;
    }

    .checkout__totals h3 {
        font-size: 22px;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        font-weight: 650;
    }

    /* Order Items */
    .order-items-container {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 10px;
        margin-bottom: 20px;
    }

    .order-item {
        display: flex;
        align-items: flex-start;
        padding: 18px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item:hover {
        background-color: #f8fafc;
    }

    .order-item-image {
        width: 80px;
        height: 80px;
        margin-right: 18px;
        flex-shrink: 0;
        border-radius: 8px;
        overflow: hidden;
        background-color: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .order-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .order-item:hover .order-item-image img {
        transform: scale(1.03);
    }

    .order-item-details {
        flex-grow: 1;
    }

    .order-item-name {
        font-weight: 600;
        margin-bottom: 6px;
        color: #1e293b;
        font-size: 15px;
    }

    .order-item-info {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .order-item-price {
        font-weight: 600;
        white-space: nowrap;
        margin-left: 15px;
        color: #1e293b;
        font-size: 15px;
    }

    /* Totals Table */
    .checkout-totals {
        width: 100%;
        margin: 20px 0;
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .checkout-totals th, 
    .checkout-totals td {
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
        text-align: left;
        color: #475569;
    }

    .checkout-totals td {
        text-align: right;
        font-weight: 500;
    }

    .checkout-totals tr.total-row th,
    .checkout-totals tr.total-row td {
        padding-top: 18px;
        font-size: 16px;
        color: #1e293b;
        font-weight: 650;
        border-top: 2px solid #f1f5f9;
    }

    /* Payment Methods */
    .checkout__payment-methods {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .checkout__payment-methods h4 {
        font-size: 18px;
        margin-bottom: 22px;
        color: #1e293b;
        font-weight: 650;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 1.25rem;
        position: relative;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 1.1rem 0.85rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: #f8fafc;
        font-size: 15px;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        background-color: #fff;
        outline: none;
    }

    /* Radio Buttons */
    .radio-group {
        margin-bottom: 20px;
        padding-left: 2rem;
    }

    .radio-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.2em;
        margin-left: -2rem;
        position: absolute;
        border: 1px solid #cbd5e1;
        border-radius: 50%;
        appearance: none;
    }

    .radio-input:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }

    .radio-label {
        font-weight: 500;
        color: #1e293b;
        cursor: pointer;
        display: block;
        margin-bottom: 0.5rem;
    }

    /* Buttons */
    .btn {
        margin: 30px;
        display: inline-block;
        padding: 16px 28px;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-align: center;
    }

    .btn-primary {
        background-color: #2a52be;
        color: white;
        box-shadow: 0 2px 5px rgba(59, 130, 246, 0.2);
    }

    .btn-primary:hover {
        background-color: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
    }

    .btn-secondary {
        background-color: #64748b;
        color: white;
        box-shadow: 0 2px 5px rgba(100, 116, 139, 0.2);
    }
    
    .btn-secondary:hover {
        background-color: #475569;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(100, 116, 139, 0.3);
    }

    .btn-block {
        display: block;
        width: 100%;
    }

    /* Feedback Messages */
    .feedback-message {
        margin-top: 12px;
        padding: 14px;
        border-radius: 8px;
        font-size: 14px;
    }
    
    .feedback-success {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    
    .feedback-error {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* Confirmation Section */
    .confirmation-container {
        max-width: 540px;
        margin: 3rem auto;
        padding: 2.5rem;
        text-align: center;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }
    
    .confirmation-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 2rem;
        background: #10b981;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }
    
    .confirmation-icon svg {
        width: 36px;
        height: 36px;
        color: white;
    }
    
    .confirmation-title {
        color: #1e293b;
        margin-bottom: 0.75rem;
        font-size: 2rem;
        font-weight: 700;
    }
    
    .confirmation-subtitle {
        color: #64748b;
        margin-bottom: 2.5rem;
        font-size: 1.1rem;
    }
    
    .summary-box {
        background: #f8fafc;
        border-radius: 10px;
        padding: 1.75rem;
        margin: 2rem 0;
        text-align: left;
        border: 1px solid #f1f5f9;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.85rem;
        padding-bottom: 0.85rem;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .summary-row:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .summary-label {
        color: #64748b;
    }
    
    .summary-value {
        font-weight: 600;
        color: #1e293b;
    }
    
    .confirmation-message {
        color: #475569;
        line-height: 1.7;
        margin: 2rem 0;
        font-size: 1.05rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2.5rem;
    }

    
    /* Utility Classes */
    .text-center {
        text-align: center;
    }

    .text-success {
        color: #10b981;
    }

    .text-danger {
        color: #ef4444;
        font-size: 13px;
        margin-top: 6px;
        display: block;
    }

    .badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }

    .badge-success {
        color: #fff;
        background-color: #10b981;
    }

    /* Custom scrollbar */
    .order-items-container::-webkit-scrollbar {
        width: 8px;
    }

    .order-items-container::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .order-items-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .order-items-container::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .checkout-form {
            flex-direction: column;
            gap: 1.5rem;
        }

        .billing-info__wrapper,
        .checkout__totals-wrapper {
            flex: 1 1 100%;
            padding: 1.5rem;
        }

        .checkout-steps {
            flex-direction: column;
        }

        .checkout-steps__item {
            margin-bottom: 12px;
        }

        .order-item-image {
            width: 70px;
            height: 70px;
        }
        
        .confirmation-container {
            padding: 1.5rem;
            margin: 1.5rem auto;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn {
            width: 100%;
        }
    }



    .confirmation-card {
        max-width: 600px;
        width: 100%;
        margin: 2rem auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .confirmation-card__body {
        padding: 2rem;
        text-align: center;
    }
    
    .confirmation-card__title {
        font-size: 1.5rem;
        color: #1e293b;
        margin-bottom: 1.5rem;
        font-weight: 650;
    }
    
    .details-list {
        list-style: none;
        padding: 0;
        margin: 0;
        text-align: left;
    }
    
    .details-list__item {
        padding: 1rem 0;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
    }
    
    .details-list__item:last-child {
        border-bottom: none;
    }
    
    .details-list__label {
        font-weight: 600;
        color: #334155;
    }
    
    .details-list__value {
        color: #475569;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        background-color: #10b981;
        color: white;
    }
    
    .back-home-btn {
        display: inline-block;
        padding: 1rem 2rem;
        background-color: #2a52be;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 2rem;
        transition: all 0.3s ease;
    }
    
    .back-home-btn:hover {
        background-color: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
    }
</style>

<!-- resources/views/orders/confirmation.blade.php -->
<div class="panier-container">
    <section class="shop-checkout container">
        <h2 class="page-title">Confirmation</h2>
        <div class="checkout-steps">
        <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
            <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                <span>Panier</span>
                <em>Gérez vos articles</em>
                </span>
        </a>

                        <a href="{{ route('cart.checkout') }}" class="checkout-steps__item active">
                            <span class="checkout-steps__item-number">02</span>
                            <span class="checkout-steps__item-title">
                            <span>Livraison et Paiement</span>
                            <em>Finalisez votre commande</em>
                            </span>
                        </a>
                
                    <a href="order-confirmation.html" class="checkout-steps__item active">
                        <span class="checkout-steps__item-number">03</span>
                        <span class="checkout-steps__item-title">
                            <span>Confirmation</span>
                            <em>Confirmez votre commande</em>
                            </span>
                    </a>
    </div>
        
            
    <div class="text-center">
            <h1 class="confirmation-title" style="color: #10b981; margin-bottom: 1rem;">
                <svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" style="vertical-align: middle; margin-right: 0.5rem;">
                    <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                Commande Confirmée
            </h1>
            <p class="confirmation-subtitle">Merci pour votre commande, {{ auth()->user()->name ?? 'Client' }} !</p>

            <div class="confirmation-card">
                <div class="confirmation-card__body">
                    <h3 class="confirmation-card__title">Détails de la commande</h3>
                    <ul class="details-list">
                        <li class="details-list__item">
                            <span class="details-list__label">ID de la commande :</span>
                            <span class="details-list__value">{{ $order }}</span>
                        </li>
                        <li class="details-list__item">
                            <span class="details-list__label">Méthode de paiement :</span>
                            <span class="details-list__value">PayPal</span>
                        </li>
                        <li class="details-list__item">
                            <span class="details-list__label">Statut :</span>
                            <span class="status-badge">Confirmée</span>
                        </li>
                        <li class="details-list__item">
                            <span class="details-list__label">Montant total :</span>
                            <span class="details-list__value">{{ number_format(\App\Models\Order::find($order)->total, 2) }} MAD</span>
                        </li>
                    </ul>
                </div>
            </div>

    <a href="{{ route('home') }}" class="btn btn-primary mt-4">
            <i class="fas fa-home me-1"></i> Retour à l'accueil
        </a>
</div>
</div>

@endsection