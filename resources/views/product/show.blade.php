@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container">
        <h1>{{ $product->name }}</h1>
        <p>{{ $product->description }}</p>
        <p>Prix : {{ $product->price }} €</p>

        <!-- Affichage de l'image principale -->
        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-fluid">

        <!-- Affichage des autres images -->
        <div class="row">
            @foreach($product->images as $image)
                <div class="col-md-3">
                @foreach($product->images as $productImage)
    <img src="{{ asset('storage/' . $productImage->image_path) }}" alt="Image produit supplémentaire">
@endforeach

            @endforeach
        </div>
    </div>
@endsection
