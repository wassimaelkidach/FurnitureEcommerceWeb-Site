@extends('layouts.admin')

@section('title', 'Ajouter un produit')

@section('content')
    <div class="container">
        <h1>Ajouter un produit</h1>

        <!-- Affichage des erreurs de validation -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Nom du produit</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <label for="price">Prix</label>
        <input type="number" name="price" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="quantity">Quantité</label>
        <input type="number" name="quantity" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="category_id">Catégorie</label>
        <select name="category_id" class="form-control" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

   
    <div class="form-group">
        <label for="colors">Select Colors</label>
        <select name="colors[]" id="colors" class="form-control" multiple required>
            @foreach($colors as $color)
                <option value="{{ $color->id }}">{{ $color->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="image">Image principale</label>
        <input type="file" name="image" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="images">Autres images</label>
        <input type="file" name="images[]" class="form-control" multiple>
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>
</div>

@endsection
