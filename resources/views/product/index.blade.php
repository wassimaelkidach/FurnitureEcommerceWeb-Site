@extends('layouts.app')

@section('content')
<!-- Formulaire de recherche -->
<



    <div class="container">
        <h1>Tous les Produits</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p>{{ $product->price }} €</p>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" class="form-control" style="width: 80px; display: inline-block;">
                                <button type="submit" class="btn btn-success">Ajouter au panier</button>
                            </form>                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-secondary">Voir détails</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
