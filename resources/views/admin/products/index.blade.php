@extends('layouts.admin')

@section('title', 'Gestion des Produits')

@section('content')
<div class="container-fluid px-4">
    <!-- Alerte Succès -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
    @endif

    <!-- Alerte Erreur -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
    @endif

    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-shopping-basket"></i> Gestion des Produits
        </h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Nouveau Produit
        </a>
    </div>

    <!-- Carte Principale -->
    <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
        <!-- Corps de la Carte -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <!-- En-têtes du Tableau -->
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Galerie</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    
                    <!-- Corps du Tableau -->
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <!-- Cellules du Tableau -->
                            <td class="ps-4 fw-semibold">#{{ $product->id }}</td>
                            <td>
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="rounded-2 shadow-sm" 
                                     width="60" 
                                     height="60" 
                                     style="object-fit: cover;"
                                     alt="{{ $product->name }}">
                                @else
                                <div class="no-image bg-light rounded-2 d-flex align-items-center justify-content-center" 
                                     style="width:60px;height:60px;">
                                    <i class="fas fa-camera text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>{{ Str::limit($product->name, 20) }}</td>
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 200px;">
                                    {{ $product->description }}
                                </span>
                            </td>
                            <td class="text-success fw-bold">{{ number_format($product->price, 2) }} MAD</td>
                            <td>
                                @if($product->images->count() > 0)
                                <div class="gallery-container" style="max-width: 200px; overflow-x: auto; white-space: nowrap;">
                                    @foreach($product->images as $image)
                                    <img src="{{ Storage::url($image->image_path) }}" 
                                         class="gallery-thumbnail rounded-2 shadow-sm me-2 cursor-zoom" 
                                         width="40" 
                                         height="40" 
                                         style="object-fit: cover; display: inline-block;"
                                         alt="Image du produit"
                                         data-bs-toggle="modal" 
                                         data-bs-target="#imageModal"
                                         data-bs-src="{{ Storage::url($image->image_path) }}">
                                    @endforeach
                                </div>
                                @else
                                <span class="badge bg-light text-muted">Aucune</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                onclick="return confirm('Êtes-vous sûr ?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-box-open text-muted" style="font-size: 3rem;"></i>
                                <h5 class="mt-3">Aucun produit trouvé</h5>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus-circle me-1"></i> Ajouter un Produit
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pied de Carte - Pagination -->
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex justify-content-center">
                @if(method_exists($products, 'links'))
                {{ $products->links() }}
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Zoom Image -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" style="max-height: 80vh;">
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .card-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: rgb(12, 73, 241);
    }
    
    .table tbody tr {
        transition: all 0.2s;
    }
    
    .table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .no-image {
        font-size: 1.25rem;
    }
    
    .rounded-pill {
        border-radius: 50px !important;
    }

    /* Styles Galerie */
    .gallery-container {
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(0,0,0,0.2) transparent;
        padding-bottom: 2px;
    }
    
    .gallery-container::-webkit-scrollbar {
        height: 1px;
    }
    
    .gallery-container::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.2);
        border-radius: 1px;
    }
    
    .cursor-zoom {
        cursor: zoom-in;
        transition: transform 0.2s;
    }
    
    .cursor-zoom:hover {
        transform: scale(1.1);
    }
    
    /* Styles Alertes */
    .alert {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: none;
        border-left: 4px solid transparent;
    }
    
    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border-left-color: #10b981;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
        border-left-color: #ef4444;
    }
    
    .alert i {
        font-size: 1.2em;
        vertical-align: middle;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fonctionnalité du modal d'image
        const imageModal = document.getElementById('imageModal');
        if (imageModal) {
            imageModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const imageUrl = button.getAttribute('data-bs-src');
                const modalImage = imageModal.querySelector('#modalImage');
                modalImage.src = imageUrl;
            });
        }
        
        // Défilement horizontal pour les galeries
        const galleries = document.querySelectorAll('.gallery-container');
        galleries.forEach(gallery => {
            gallery.addEventListener('wheel', function(e) {
                if (e.deltaY === 0) return;
                e.preventDefault();
                this.scrollLeft += e.deltaY;
            });
        });

        // Fermeture automatique des alertes après 5 secondes
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endsection