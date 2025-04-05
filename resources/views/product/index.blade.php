@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tous les Produits</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
    <div class="card h-100">
        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
        <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
            <p class="mt-auto font-weight-bold">{{ number_format($product->price, 2) }} €</p>
            
            <form action="{{ route('cart.add', ['product' => $product->id]) }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <select name="color" class="form-select" required>
                            <option value="">Select Color</option>
                            @foreach(explode(',', $product->colors) as $color)
                                <option value="{{ trim($color) }}">{{ trim($color) }}</option>
                            @endforeach
                        </select>
                    </div>
                  
                </div>
                
                <div class="d-flex gap-2">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width: 70px;" required>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-cart-plus"></i> Ajouter
                    </button>
                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
            </div>
        @endforeach
    </div>
</div>
@endsection