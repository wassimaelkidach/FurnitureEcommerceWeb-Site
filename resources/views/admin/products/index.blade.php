@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Gestion des Produits</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Ajouter un produit</a>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="product card">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Image principale du produit" class="card-img-top">

                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text"><strong>Prix: </strong>{{ $product->price }} €</p>

                            <!-- Images supplémentaires -->
                            <div class="product-images">
                                <h6>Autres images:</h6>
                                @foreach($product->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image produit supplémentaire" class="img-thumbnail" width="100">
                                @endforeach
                            </div>

                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info">Modifier</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
