@extends('layouts.admin')

@section('title', 'Gestion des Produits')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-shopping-basket"></i> Gestion des Produits
        </h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Nouveau Produit
        </a>
    </div>

    <!-- Carte principale -->
    <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
        <!-- Corps de carte -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <!-- En-têtes de tableau -->
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
                    
                    <!-- Corps de tableau -->
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <!-- Contenu des cellules -->
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
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         class="gallery-thumbnail rounded-2 shadow-sm me-2 cursor-zoom" 
                                         width="40" 
                                         height="40" 
                                         style="object-fit: cover; display: inline-block;"
                                         alt="Image produit"
                                         data-bs-toggle="modal" 
                                         data-bs-target="#imageModal"
                                         data-bs-image="{{ asset('storage/' . $image->image_path) }}">
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
                                    <i class="fas fa-plus-circle me-1"></i> Ajouter un produit
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pied de carte - Pagination -->
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex justify-content-center">
                @if(method_exists($products, 'links'))
                {{ $products->links() }}
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal pour l'affichage zoomé -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        background-color: rgb(103, 125, 148);
    }
    
    .no-image {
        font-size: 1.25rem;
    }
    
    .rounded-pill {
        border-radius: 50px !important;
    }

    /* Styles pour la galerie */
    .gallery-container {
        overflow-x: auto;
    scrollbar-width: thin; /* Pour Firefox */
    scrollbar-color: rgba(78, 77, 77, 0.2) transparent; /* Couleur très discrète */
    padding-bottom: 2px;
    }
    
    .gallery-container::-webkit-scrollbar {
    height: 1px; /* Épaisseur très fine */
}
    
.gallery-container::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2); /* Gris très clair */
    border-radius: 1px;
}
    
    /* .gallery-container::-webkit-scrollbar-thumb {
        background-color: #ddd;
        border-radius: 10px;
    } */
    
    .cursor-zoom {
        cursor: zoom-in;
        transition: transform 0.2s;
    }
    
    .cursor-zoom:hover {
        transform: scale(1.1);
    }
    
    .modal-content {
        background-color: transparent;
        border: none;
    }
    
    .modal-header {
        border-bottom: none;
    }
    
    .btn-close {
        filter: invert(1);
        opacity: 0.8;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageModal = document.getElementById('imageModal');
        if (imageModal) {
            imageModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const imageUrl = button.getAttribute('data-bs-image');
                const modalImage = imageModal.querySelector('#modalImage');
                modalImage.src = imageUrl;
            });
        }
        
        // Style personnalisé pour le scroll horizontal
        const galleries = document.querySelectorAll('.gallery-container');
        galleries.forEach(gallery => {
            gallery.addEventListener('wheel', function(e) {
                if (e.deltaY === 0) return;
                e.preventDefault();
                this.scrollLeft += e.deltaY;
            });
        });
    });
</script>
@endsection