@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                <h1 class="h3 mb-0">Édition du produit</h1>
                <!-- <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a> -->
            </div>
            <p class="text-muted mt-2">Mise à jour des informations produit</p>
        </div>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="product-edit-form">
        @csrf
        @method('PUT')
        
        <!-- Champ caché pour les images supprimées -->
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
                            <label for="price" class="form-label">Prix (MAD)</label>
                            <div class="input-group">
                                <span class="input-group-text">MAD</span>
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="{{ old('price', $product->price) }}" step="0.01" required>
                            </div>
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
                                @forelse($product->images as $image)
                                <div class="col-4 col-md-3 gallery-item" data-id="{{ $image->id }}">
                                    <div class="position-relative border rounded p-1 bg-light">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             class="img-fluid rounded" 
                                             style="height: 100px; width: 100%; object-fit: cover;" 
                                             alt="Image galerie">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-1 delete-image">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12 text-center text-muted py-3" id="no-gallery-message">
                                    <i class="fas fa-images fa-2x mb-2"></i>
                                    <p class="mb-0">Aucune image supplémentaire</p>
                                </div>
                                @endforelse
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
                    <button type="submit" class="btn btn-primary px-4" id="submit-btn">
                        <i class="fas fa-save me-2"></i> Enregistrer
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4">
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Tableau pour stocker les IDs des images supprimées
    let deletedImages = [];

    // Gestion de la suppression des images
    $(document).on('click', '.delete-image', function() {
        const $item = $(this).closest('.gallery-item');
        const imageId = $item.data('id');
        
        if(confirm('Supprimer cette image ?')) {
            if(imageId) {
                deletedImages.push(imageId);
                $('#deleted_images').val(JSON.stringify(deletedImages));
            }
            $item.remove();
            
            // Si plus d'images, afficher le message
            if($('#gallery-container .gallery-item').length === 0) {
                $('#gallery-container').html(`
                    <div class="col-12 text-center text-muted py-3" id="no-gallery-message">
                        <i class="fas fa-images fa-2x mb-2"></i>
                        <p class="mb-0">Aucune image supplémentaire</p>
                    </div>
                `);
            }
        }
    });

    // Prévisualisation de la nouvelle image principale
    $('#image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if ($('#no-image-message').length) {
                    $('#no-image-message').remove();
                }
                if (!$('#current-image').length) {
                    $('#current-image-container').html('<img id="current-image" class="img-fluid rounded mb-2" style="max-height: 200px; object-fit: contain;">');
                }
                $('#current-image').attr('src', e.target.result);
                $('#image-filename').text(file.name);
            }
            reader.readAsDataURL(file);
        }
    });

    // Affichage du nombre de fichiers sélectionnés pour la galerie
    $('#images').change(function() {
        if (this.files.length > 0) {
            $('#gallery-filename').text(`${this.files.length} fichier(s) sélectionné(s)`);
        } else {
            $('#gallery-filename').text('Ajouter des images');
        }
    });

    // Soumission du formulaire
    $('#product-edit-form').on('submit', function(e) {
        e.preventDefault();
        
        // Afficher un loader pendant la soumission
        $('#submit-btn').html('<i class="fas fa-spinner fa-spin me-2"></i> Enregistrement...').prop('disabled', true);
        
        // Soumettre le formulaire via AJAX
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                // Rediriger vers la liste des produits avec un message de succès
                window.location.href = "{{ route('admin.products.index') }}";
            },
            error: function(xhr) {
                // Réactiver le bouton
                $('#submit-btn').html('<i class="fas fa-save me-2"></i> Enregistrer').prop('disabled', false);
                
                // Afficher les erreurs de validation
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    
                    $.each(errors, function(key, value) {
                        errorMessages += `<li>${value[0]}</li>`;
                    });
                    
                    alert(`Erreurs de validation:\n${errorMessages}`);
                } else {
                    alert('Une erreur est survenue. Veuillez réessayer.');
                }
            }
        });
    });
});
</script>
@endsection