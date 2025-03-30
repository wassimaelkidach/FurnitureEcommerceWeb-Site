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

        <!-- Formulaire d'ajout de produit -->
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nom du produit</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Prix</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" required>
            </div>

            <div class="form-group">
                <label for="category_id">Catégorie</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Sélectionner une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Champ pour l'image principale -->
            <div class="form-group">
                <label for="image">Image principale du produit</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>

            <!-- Champ pour les autres images -->
            <div class="form-group">
                <label for="images">Autres images du produit</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter le produit</button>
        </form>
    </div>
@endsection
