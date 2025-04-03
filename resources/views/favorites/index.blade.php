@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mes Favoris</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($favorites->count() > 0)
        <div class="row">
            @foreach($favorites as $favorite)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $favorite->product->image) }}" class="card-img-top" alt="{{ $favorite->product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $favorite->product->name }}</h5>
                            <p class="card-text">{{ number_format($favorite->product->price, 2) }} MAD</p>
                            <form action="{{ route('favorites.destroy', $favorite->product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Retirer</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Vous n'avez aucun favori.</p>
    @endif

    <!-- Section pour afficher des produits random -->
    <h3 class="mt-5">Vous pourriez aussi aimer</h3>
    <div class="row">
        @foreach($randomProducts as $product)
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ number_format($product->price, 2) }} MAD</p>
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
