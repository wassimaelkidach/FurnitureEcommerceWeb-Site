@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container">
        <h1>{{ $product->name }}</h1>
        <p>Note moyenne : ⭐{{ round($product->reviews->avg('rating'), 1) }}/5</p>

        <p>{{ $product->description }}</p>
        <p>Prix : {{ $product->price }} €</p>

        <!-- Affichage de l'image principale -->
        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-fluid">

        <!-- Affichage des autres images -->
        <div class="row mt-3">
            @foreach($product->images as $image)
                <div class="col-md-3">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image produit supplémentaire" class="img-thumbnail">
                </div>
            @endforeach
        </div>
    </div>

    <!-- Section des avis -->
    <div class="mt-4">
        <h3>Avis des clients :</h3>

        <!-- Affichage des avis existants -->
        @foreach($product->reviews as $review)
            <div class="review-box border p-3 my-2">
                <strong>{{ $review->user->name }}</strong> - ⭐{{ $review->rating }}/5
                <p>{{ $review->comment }}</p>
                <small>Posté le {{ $review->created_at->format('d/m/Y') }}</small>
            </div>
        @endforeach

        <!-- Formulaire d'ajout d'un avis -->
        @auth
            <div class="mt-3">
                <h4>Laisser un avis :</h4>
                <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                    @csrf
                    <label for="rating">Note :</label>
                    <select name="rating" required class="form-control w-25">
                        <option value="5">⭐️⭐️⭐️⭐️⭐️</option>
                        <option value="4">⭐️⭐️⭐️⭐️</option>
                        <option value="3">⭐️⭐️⭐️</option>
                        <option value="2">⭐️⭐️</option>
                        <option value="1">⭐️</option>
                    </select>

                    <label for="comment" class="mt-2">Votre avis :</label>
                    <textarea name="comment" class="form-control" rows="3" required></textarea>

                    <button type="submit" class="btn btn-primary mt-2">Soumettre</button>
                </form>
            </div>
        @else
            <p><a href="{{ route('login') }}">Connectez-vous</a> pour laisser un avis.</p>
        @endauth
    </div>
@endsection
