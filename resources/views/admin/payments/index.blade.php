@extends('layouts.admin')

@section('content')
<div class="content-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestion des Paiements</h2>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Commande</th>
                    <th>Montant</th>
                    <th>Méthode</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>#{{ $payment->id }}</td>
                    <td>Commande #{{ $payment->order_id }}</td>
                    <td>{{ number_format($payment->amount, 2) }} €</td>
                    <td>{{ ucfirst($payment->payment_method) }}</td>
                    <td>
                        <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : ($payment->status === 'failed' ? 'danger' : 'warning') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $payments->links() }}
    </div>
</div>
@endsection