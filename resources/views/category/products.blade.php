@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Produits de la catégorie : {{ $category->name }}</h1>

        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ asset('images/product-placeholder.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">Voir les détails</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
