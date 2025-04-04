@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Mon Panier</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $productId => $product)
                        <tr>
                            <td><img src="{{ asset('storage/'.$product['image']) }}" width="50"></td>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['price'] }} €</td>
                            <td>
                                <form action="{{ route(name: 'cart.update') }}" method="POST">
                                    @csrf
                                    <input type="number" name="quantities[{{ $productId }}]" value="{{ $product['quantity'] }}" min="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Mettre à jour</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Résumé de commande -->
            <div class="order-summary">
                <h3>Résumé de la commande</h3>
                <p><strong>Total des articles : </strong> {{ $totalItems }} articles</p>
                <p><strong>Total : </strong> {{ $totalPrice }} €</p>
                <a href="{{ route('cart.checkout') }}" class="btn btn-success">Passer à la caisse</a>
            </div>
        @else
            <p>Votre panier est vide.</p>
        @endif
    </div>

        <!-- Ajout de la section "Vous voulez le remplir aussi ?" -->
        <div class="mt-4 text-center">
            <h3>Vous voulez le remplir aussi ?</h3>
            <p>Découvrez nos produits et ajoutez-les à votre panier.</p>
            <div class="row">
                @foreach($randomProducts as $product)
                    <div class="col-md-3">
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
                            </form>                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
