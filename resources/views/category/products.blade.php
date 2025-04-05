@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Produits de la catégorie : {{ $category->name }}</h1>

        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card">
                        <!-- Affichage de l'image principale du produit -->
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">

                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <p class="card-text"><strong>{{ $product->price }} MAD</strong></p>
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">Voir les détails</a>

                            <!-- Formulaire pour ajouter le produit au panier -->
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                                <input type="number" name="quantity" value="1" min="1" class="form-control" style="width: 80px; display: inline-block;">
                                <button type="submit" class="btn btn-success">Ajouter au panier</button>
                            </form>
                            <form action="{{ route('favorites.store', $product->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-outline-danger">❤️ Ajouter aux favoris</button>
</form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
