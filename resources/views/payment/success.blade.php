@extends('layouts.app')

@section('content')
<div class="payment-success">
    <div class="success-message">
        <i class="fas fa-check-circle"></i>
        <h1>Paiement Réussi!</h1>
        <p>Votre commande #{{ $order->id }} a été confirmée.</p>
        <p>Un email de confirmation vous a été envoyé.</p>
        <a href="{{ route('home') }}" class="btn-home">Retour à l'accueil</a>
    </div>
</div>
@endsection

<style>
.payment-success {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 70vh;
    padding: 2rem;
}

.success-message {
    text-align: center;
    max-width: 500px;
    padding: 2rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.success-message i {
    font-size: 4rem;
    color: #28a745;
    margin-bottom: 1rem;
}

.success-message h1 {
    color: #28a745;
    margin-bottom: 1rem;
}

.btn-home {
    display: inline-block;
    margin-top: 1.5rem;
    padding: 0.8rem 1.5rem;
    background: #007bff;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-home:hover {
    background: #0056b3;
    transform: translateY(-2px);
}
</style>