@extends('layouts.app')

@section('content')
<style>
    .payment-cancelled-container {
        min-height: 70vh;
        display: flex;
        align-items: center;
    }
    .cancelled-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .cancelled-card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
        font-size: 1.25rem;
        font-weight: 600;
        padding: 1.25rem;
        text-align: center;
    }
    .cancelled-alert {
        border-left: 4px solid #ffc107;
        background-color: rgba(255, 193, 7, 0.1);
    }
    .btn-retry {
        background-color: #2a52be;
        border: none;
        padding: 0.5rem 1.5rem;
        transition: all 0.3s ease;
    }
    .btn-retry:hover {
        background-color: #1a3a8a;
        transform: translateY(-2px);
    }
    .btn-home {
        background-color: #6c757d;
        border: none;
        padding: 0.5rem 1.5rem;
        transition: all 0.3s ease;
    }
    .btn-home:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }
</style>

<div class="payment-cancelled-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card cancelled-card">
                    <div class="card-header cancelled-card-header">Paiement Annulé</div>

                    <div class="card-body text-center">
                        <div class="alert alert-warning cancelled-alert mx-auto" style="max-width: 500px;">
                            Vous avez annulé le processus de paiement.
                        </div>
                        <p class="mb-4">Aucun prélèvement n'a été effectué sur votre compte.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('payment.form') }}" class="btn btn-primary btn-retry">
                                <i class="fas fa-undo me-2"></i>Réessayer
                            </a>
                            <a href="/" class="btn btn-secondary btn-home">
                                <i class="fas fa-home me-2"></i>Retour à l'accueil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection