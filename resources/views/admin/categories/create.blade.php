@extends('layouts.admin')

@section('title', 'Ajouter une catégorie')

@section('content')
    <div class="container">
        <h1>Ajouter une nouvelle catégorie</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Nom de la catégorie :</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="image">Image :</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-success mt-3">Ajouter</button>
        </form>
    </div>
@endsection
