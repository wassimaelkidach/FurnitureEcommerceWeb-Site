@extends('layouts.admin')

@section('content')
<div class="content-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Détails du Paiement #{{ $payment->id }}</h2>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informations Paiement</h5>
                </div>
                <div class="card-body">
                    <p><strong>Commande:</strong> #{{ $payment->order_id }}</p>
                    <p><strong>Montant:</strong> {{ number_format($payment->amount, 2) }} €</p>
                    <p><strong>Méthode:</strong> {{ ucfirst($payment->payment_method) }}</p>
                    <p><strong>Statut:</strong> 
                        <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : ($payment->status === 'failed' ? 'danger' : 'warning') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </p>
                    <p><strong>Date:</strong> {{ $payment->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Notes</h5>
                </div>
                <div class="card-body">
                    {{ $payment->notes ?? 'Aucune note' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection