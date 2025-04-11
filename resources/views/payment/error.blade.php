@extends('layouts.app')

@section('content')
<style>
:root {
    --primary: #2a52be;
    --primary-dark: #1a3a8a;
    --error: #ff4242;
    --text: #333;
    --light-bg: #f9f9f9;
    --border: #e0e0e0;
    --shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.payment-error-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
    min-height: 60vh;
}

.payment-error-card {
    background: white;
    border-radius: 8px;
    box-shadow: var(--shadow);
    overflow: hidden;
}

.payment-error-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border);
    background-color: #f5f7fa;
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text);
}

.payment-error-body {
    padding: 1.5rem;
}

.alert-danger {
    background-color: rgba(255, 66, 66, 0.1);
    border-left: 4px solid var(--error);
    color: var(--error);
    padding: 1rem;
    margin-bottom: 1.5rem;
    border-radius: 4px;
}

.payment-error-message {
    margin-bottom: 1.5rem;
    color: var(--text);
}

.btn-primary {
    background-color: var(--primary);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.2s ease;
    margin-right: 1rem;
}

.btn-primary:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px);
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-secondary:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .payment-error-header {
        padding: 1rem;
        font-size: 1.25rem;
    }
    
    .payment-error-body {
        padding: 1rem;
    }
    
    .btn-primary, .btn-secondary {
        display: block;
        width: 100%;
        margin-bottom: 1rem;
        margin-right: 0;
    }
}
</style>

<div class="payment-error-container">
    <div class="payment-error-card">
        <div class="payment-error-header">Erreur de Paiement</div>

        <div class="payment-error-body">
            <div class="alert alert-danger">
                Une erreur est survenue lors du processus de paiement.
            </div>
            <p class="payment-error-message">
                {{ session('error') ?? 'Un problème est survenu avec votre paiement. Veuillez réessayer ou contacter le support si le problème persiste.' }}
            </p>
            <div class="button-group">
                <a href="{{ route('paypal.process') }}" class="btn btn-primary">Réessayer</a>
                <a href="/" class="btn btn-secondary">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</div>
@endsection