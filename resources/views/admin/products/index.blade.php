@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">Gestion des Produits</h1>

        <a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">+ Ajouter un produit</a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Quantité</th> <!-- Nouvelle colonne pour la quantité -->
                        <th>Autres images</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td class="text-truncate" style="max-width: 200px;">{{ $product->description }}</td>
                            <td><strong>{{ $product->price }} €</strong></td>
                            <td><strong>{{ $product->quantity }}</strong></td> <!-- Affichage de la quantité -->
                            <td>
                                @if($product->images->count())
                                    @foreach($product->images as $image)
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image produit supplémentaire" class="img-thumbnail" width="40">
                                    @endforeach
                                @else
                                    <span class="text-muted">Aucune</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info btn-sm">Modifier</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
