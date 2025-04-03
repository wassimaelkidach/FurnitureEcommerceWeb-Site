@extends('layouts.app')

@section('content')

<form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="address">Adresse de livraison</label>
        <input type="text" name="address" id="address" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="postal_code">Code postal</label>
        <input type="text" name="postal_code" id="postal_code" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="phone">Numéro de téléphone</label>
        <input type="text" name="phone" id="phone" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Procéder au paiement</button>
</form>
@endsection