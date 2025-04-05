@extends('layouts.admin')

@section('title', 'Modifier le Produit')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                <h1 class="h3 mb-0">Modifier le Produit</h1>
            </div>
            <p class="text-muted mt-2">Mettre à jour les informations du produit</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="product-edit-form">
        @csrf
        @method('PUT')
        
        <!-- Champ caché pour stocker les IDs des images supprimées -->
        <input type="hidden" name="deleted_images" id="deleted_images" value="">
        
        <div class="row g-4">
            <!-- Section gauche - Informations produit -->
            <div class="col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-4">Informations de base</h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom du produit</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $product->name) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="5" required>{{ old('description', $product->description) }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Catégorie</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section caractéristiques produit -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-4">Caractéristiques</h5>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Prix (MAD)</label>
                            <div class="input-group">
                                <span class="input-group-text">MAD</span>
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantité en stock</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" 
                                   value="{{ old('quantity', $product->quantity) }}" min="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="colors" class="form-label">Couleurs disponibles</label>
                            <select name="colors[]" id="colors" class="form-select" multiple>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}" 
                                        {{ $product->colors->contains($color->id) ? 'selected' : '' }}>
                                        {{ $color->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Section droite - Images -->
            <div class="col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-4">Images</h5>
                        
                        <!-- Image principale -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Image principale</h6>
                            
                            <div class="border rounded p-3 mb-3 text-center bg-light" id="current-image-container">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="img-fluid rounded mb-2" 
                                         style="max-height: 200px; object-fit: contain;" 
                                         alt="Image actuelle" id="current-image">
                                    <!-- <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="remove-main-image">
                                            <i class="fas fa-trash-alt me-1"></i> Supprimer
                                        </button>
                                    </div> -->
                                @else
                                    <div class="text-muted py-4" id="no-image-message">
                                        <i class="fas fa-image fa-2x mb-2"></i>
                                        <p class="mb-0">Aucune image principale</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="file-upload-wrapper">
                                <label for="image" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-upload me-2"></i> Changer l'image
                                </label>
                                <input type="file" class="d-none" id="image" name="image" accept="image/*">
                                <div class="file-name mt-2 small text-muted" id="image-filename"></div>
                            </div>
                        </div>
                        
                        <!-- Galerie d'images -->
                        <div>
                            <h6 class="fw-bold mb-3">Galerie d'images</h6>
                            
                            <div class="row g-2 mb-3" id="gallery-container">
                                @if($product->images->isEmpty())
                                    <div class="col-12 text-center text-muted py-3" id="no-gallery-message">
                                        <i class="fas fa-images fa-2x mb-2"></i>
                                        <p class="mb-0">Aucune image supplémentaire</p>
                                    </div>
                                @else
                                    @foreach($product->images as $image)
                                    <div class="col-4 col-md-3 gallery-item" data-image-id="{{ $image->id }}">
                                        <div class="position-relative border rounded p-1 bg-light">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                 class="img-fluid rounded" 
                                                 style="height: 100px; width: 100%; object-fit: cover;" 
                                                 alt="Image galerie">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-1 remove-gallery-image">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="file-upload-wrapper">
                                <label for="images" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-plus me-2"></i> Ajouter des images
                                </label>
                                <input type="file" class="d-none" id="images" name="images[]" multiple accept="image/*">
                                <div class="file-name mt-2 small text-muted" id="gallery-filename"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-primary px-4" id="submit-btn">
                        <i class="fas fa-save me-2"></i> Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('styles')
<style>
    /* Styles améliorés pour les sélecteurs multiples */
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        padding: 0.375rem 0.75rem;
        min-height: calc(1.5em + 0.75rem + 2px);
    }
    
    /* Style pour les badges de couleur */
    .color-badge {
        display: inline-block;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        margin-right: 5px;
        vertical-align: middle;
    }
    
    /* Style pour les images */
    .file-upload-wrapper {
        position: relative;
        margin-bottom: 1rem;
    }
    
    .file-name {
        word-break: break-all;
    }
    
    /* Style pour la galerie */
    .gallery-container {
        min-height: 120px;
    }
    
    /* Style pour les boutons de suppression */
    .remove-gallery-image {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
</style>
@endsection

@section('scripts')
<!-- Inclusion de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialisation de Select2 pour les couleurs
    $('#colors').select2({
        placeholder: "Sélectionnez des couleurs",
        allowClear: true
    });

    // Gestion de la suppression de l'image principale
    $('#remove-main-image').click(function() {
        $('#current-image-container').html(`
            <div class="text-muted py-4" id="no-image-message">
                <i class="fas fa-image fa-2x mb-2"></i>
                <p class="mb-0">Aucune image principale</p>
            </div>
        `);
        // Ajouter un marqueur spécial pour l'image principale
        let deleted = $('#deleted_images').val();
        $('#deleted_images').val(deleted ? 'main,' + deleted : 'main');
    });

    // Gestion de la suppression des images de la galerie
    $(document).on('click', '.remove-gallery-image', function() {
        const imageId = $(this).closest('.gallery-item').data('image-id');
        $(this).closest('.gallery-item').remove();
        
        // Ajouter l'ID de l'image supprimée
        let deleted = $('#deleted_images').val();
        $('#deleted_images').val(deleted ? deleted + ',' + imageId : imageId);
        
        // Afficher message si plus d'images
        if ($('#gallery-container .gallery-item').length === 0) {
            $('#gallery-container').html(`
                <div class="col-12 text-center text-muted py-3" id="no-gallery-message">
                    <i class="fas fa-images fa-2x mb-2"></i>
                    <p class="mb-0">Aucune image supplémentaire</p>
                </div>
            `);
        }
    });

    // Affichage du nom du fichier pour l'image principale
    $('#image').change(function() {
        if (this.files.length > 0) {
            $('#image-filename').text(this.files[0].name);
        } else {
            $('#image-filename').text('');
        }
    });

    // Affichage des noms des fichiers pour la galerie
    $('#images').change(function() {
        if (this.files.length > 0) {
            let fileNames = [];
            for (let i = 0; i < this.files.length; i++) {
                fileNames.push(this.files[i].name);
            }
            $('#gallery-filename').text(fileNames.join(', '));
        } else {
            $('#gallery-filename').text('');
        }
    });

    // Prévisualisation des nouvelles images de la galerie
    $('#images').change(function() {
        const files = this.files;
        
        for (let i = 0; i < files.length; i++) {
            if (files[i].type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Supprimer le message s'il existe
                    if ($('#no-gallery-message').length) {
                        $('#no-gallery-message').remove();
                    }
                    
                    // Ajouter la nouvelle image à la galerie
                    $('#gallery-container').append(`
                        <div class="col-4 col-md-3 gallery-item new-image">
                            <div class="position-relative border rounded p-1 bg-light">
                                <img src="${e.target.result}" 
                                     class="img-fluid rounded" 
                                     style="height: 100px; width: 100%; object-fit: cover;" 
                                     alt="Nouvelle image">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-1 remove-new-image">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    `);
                };
                reader.readAsDataURL(files[i]);
            }
        }
    });

    // Suppression des nouvelles images avant envoi
    $(document).on('click', '.remove-new-image', function() {
        $(this).closest('.gallery-item').remove();
    });
});
</script>