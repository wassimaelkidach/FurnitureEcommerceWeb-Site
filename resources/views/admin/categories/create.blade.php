@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Ajouter une catégorie</h1>
        
        <!-- Formulaire d'ajout de catégorie -->
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Nom de la catégorie</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="image">Image de la catégorie (facultatif)</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Ajouter la catégorie</button>
        </form>
    </div>
@endsection
