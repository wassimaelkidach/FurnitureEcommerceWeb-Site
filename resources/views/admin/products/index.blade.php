@extends('layouts.admin')

@section('title', 'Gestion des Produits')

@php
    // Définition de la fonction helper directement dans la vue
    if (!function_exists('getContrastColor')) {
        function getContrastColor($hexColor) {
            // Supprime le # si présent
            $hexColor = ltrim($hexColor, '#');
            
            // Convertit en valeurs RGB
            $r = hexdec(substr($hexColor, 0, 2));
            $g = hexdec(substr($hexColor, 2, 2));
            $b = hexdec(substr($hexColor, 4, 2));
            
            // Calcul de la luminosité (formule W3C)
            $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
            
            // Retourne noir ou blanc selon la luminosité
            return $brightness > 128 ? '#000000' : '#FFFFFF';
        }
    }
@endphp

@section('content')
<div class="container-fluid px-4">
    <!-- Alertes -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

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
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <!-- <th class="ps-4">ID</th> -->
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Couleurs</th>
                            <th>Galerie</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <!-- <td class="ps-4 fw-semibold">#{{ $product->id }}</td> -->
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
                            <td class="fw-bold">{{ $product->quantity }}</td>
                            <td>
                                @if($product->colors->count())
                                    @foreach($product->colors as $color)
                                        <span class="badge rounded-pill me-1" style="background-color: {{ $color->hex_code }}; color: {{ getContrastColor($color->hex_code) }};">
                                            {{ $color->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="badge bg-light text-muted">Aucune</span>
                                @endif
                            </td>
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
                            <td colspan="9" class="text-center py-5">
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
        
        <!-- Pagination -->
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
    .color-badge {
        transition: all 0.3s ease;
    }
    .color-badge:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .cursor-zoom {
        cursor: zoom-in;
    }
    .gallery-container::-webkit-scrollbar {
        height: 5px;
    }
    .gallery-container::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .gallery-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    .gallery-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du modal d'image
        const imageModal = document.getElementById('imageModal');
        if (imageModal) {
            imageModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const imageSrc = button.getAttribute('data-bs-src');
                const modalImage = imageModal.querySelector('#modalImage');
                modalImage.src = imageSrc;
            });
        }
    });
</script>
@endsection