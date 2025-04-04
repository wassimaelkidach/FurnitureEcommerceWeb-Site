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
                        
                        <div class="d-flex gap-2 mt-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="d-flex">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width: 70px;">
                                <button type="submit" class="btn btn-success ms-2">
                                    <i class="fas fa-cart-plus"></i> Ajouter
                                </button>
                            </form>
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection