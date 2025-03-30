@extends('layouts.admin')

@section('title', 'Gérer les catégories')

@section('content')
    <div class="container">
        <h1>Gérer les catégories</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="Image" width="50">
                            @else
                                <p>No Image</p>
                            @endif
                        </td>
                        <td>
                            <!-- Bouton pour la modification -->
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-info btn-sm">Modifier</a>

                            <!-- Formulaire pour la suppression -->
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
