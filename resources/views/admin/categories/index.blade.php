@extends('layouts.admin')

@section('title', 'Gérer les catégories')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-tag me-2"></i>Gestion des categories
        </h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Nouveau categories
        </a>
    </div>

    <div class="card shadow-lg">
        <!-- Barre de recherche -->
        <div class="card-header bg-white border-bottom-0 py-4">
            <form action="{{ route('admin.categories.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" 
                           name="search" 
                           class="form-control rounded-pill" 
                           placeholder="Rechercher une catégorie..." 
                           value="{{ request('search') }}"
                           aria-label="Rechercher">
                    <button class="btn btn-primary rounded-pill ms-2 px-4" type="submit">
                        <i class="fas fa-search me-1"></i> Rechercher
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary rounded-pill ms-2">
                            <i class="fas fa-times me-1"></i> Annuler
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card-body px-0 pb-0">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-4 rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Nom</th>
                            <th>Image</th>
                            <th>Produits</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr class="position-relative">
                            <td class="ps-4 fw-semibold">{{ $category->name }}</td>
                            <td>
                                @if($category->image)
                                <div class="image-preview-container">
                                    <img src="{{ Storage::url($category->image) }}" 
                                         class="rounded-2 shadow-sm" 
                                         width="60" 
                                         height="60" 
                                         style="object-fit: cover;"
                                         alt="{{ $category->name }}">
                                </div>
                                @else
                                <span class="badge bg-light text-muted">Aucune image</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill">{{ $category->products_count ?? 0 }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                       data-bs-toggle="tooltip" 
                                       title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                data-bs-toggle="tooltip"
                                                title="Supprimer"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bi bi-folder-x text-muted" style="font-size: 3rem;"></i>
                                <h5 class="mt-3">Aucune catégorie trouvée</h5>
                                <p class="text-muted">
                                    @if(request('search'))
                                        Aucun résultat pour "{{ request('search') }}"
                                    @else
                                        Commencez par ajouter votre première catégorie
                                    @endif
                                </p>
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-2">
                                    <i class="bi bi-plus-circle me-1"></i> Ajouter une catégorie
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @isset($categories->links)
        <div class="card-footer bg-white border-top-0 py-3">
            {{ $categories->links() }}
        </div>
        @endisset
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Activer les tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
@endsection

@section('styles')
<style>
    /* Styles globaux améliorés */
    .pagination {
        justify-content: center;
    }
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .pagination .page-link {
        margin: 0 5px;
        border-radius: 50%;
    }
    /* Style pour la barre de recherche */
    .input-group {
        max-width: 500px;
    }
</style>
@endsection