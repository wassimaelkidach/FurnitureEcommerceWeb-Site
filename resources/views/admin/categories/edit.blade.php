@extends('layouts.admin')

@section('title', 'Modifier la catégorie')

@section('content')
    <div class="container">
        <h1>Modifier la catégorie</h1>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="name">Nom de la catégorie</label>
                <input type="text" name="name" value="{{ $category->name }}" required>
            </div>

            <div>
                <label for="image">Image</label>
                <input type="file" name="image">
                <img src="{{ asset('storage/' . $category->image) }}" alt="Image actuelle" width="100">
            </div>

            <button type="submit">Mettre à jour</button>
        </form>
    </div>
@endsection
