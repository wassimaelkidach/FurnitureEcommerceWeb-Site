@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Modifier le produit</h1>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div>
                <label for="name">Nom</label>
                <input type="text" name="name" value="{{ $product->name }}" id="name" required>
            </div>
            <div>
                <label for="description">Description</label>
                <textarea name="description" id="description" required>{{ $product->description }}</textarea>
            </div>
            <div>
                <label for="price">Prix</label>
                <input type="number" name="price" value="{{ $product->price }}" id="price" required>
            </div>
            <div>
                <label for="quantity">quantite</label>
                <input type="number" name="quantity" value="{{ $product->quantity }}" id="quantity" required>
            </div>
            <div>
                <label for="main_image">Image principale</label>
                <input type="file" name="main_image" id="main_image">
            </div>
            <div>
                <label for="images">Images supplémentaires</label>
                <input type="file" name="images[]" id="images" multiple>
            </div>
            
            <button type="submit">Mettre à jour le produit</button>
        </form>
    </div>
@endsection
