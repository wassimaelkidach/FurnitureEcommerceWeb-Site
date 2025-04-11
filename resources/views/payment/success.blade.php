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

    <div class="container py-5">
    <div class="text-center">
        <h1 class="text-success"><i class="fas fa-check-circle"></i> Commande Confirmée</h1>
        <p class="lead">Merci pour votre commande, {{ auth()->user()->name ?? 'Client' }} !</p>

        <div class="card mx-auto mt-4" style="max-width: 600px;">
            <div class="card-body">
                <h5 class="card-title">Détails de la commande</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>ID de la commande :</strong> {{ $order }}</li>
                    <li class="list-group-item"><strong>Méthode de paiement :</strong> PayPal</li>
                    <li class="list-group-item"><strong>Statut :</strong> <span class="badge bg-success">Confirmée</span></li>
                    <li class="list-group-item"><strong>Montant total :</strong> {{ number_format(\App\Models\Order::find($order)->total, 2) }} $</li>
                </ul>
            </div>
        </div>

        <a href="{{ route('home') }}" class="btn btn-primary mt-4">
            <i class="fas fa-home me-1"></i> Retour à l'accueil
        </a>
    </div>
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