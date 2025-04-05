@extends('layout.stripe')

@section('content')
<div class="card">
    <div class="card-header">Stripe Payment</div>
    <div class="card-body">
        <form method="POST" action="{{ route('stripe.checkout') }}">
            @csrf

            <div class="form-group mb-3">
                <label>Amount ($)</label>
                <input type="number" name="amount" class="form-control" required min="1" step="0.01">
            </div>

            <div class="form-group mb-3">
                <label>Description</label>
                <input type="text" name="description" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Pay with Stripe</button>
        </form>
    </div>
</div>
@endsection