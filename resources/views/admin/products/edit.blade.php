@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                <h1 class="h3 mb-0">Modifier le Produit</h1>
                <!-- <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a> -->
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
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Prix (MAD)</label>
                            <div class="input-group">
                                <span class="input-group-text">MAD</span>
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
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
                                @if($product->images->isEmpty())
                                    <div class="col-12 text-center text-muted py-3" id="no-gallery-message">
                                        <i class="fas fa-images fa-2x mb-2"></i>
                                        <p class="mb-0">Aucune image supplémentaire</p>
                                    </div>
                                @else
                                    @foreach($product->images as $image)
                                    <div class="col-4 col-md-3 gallery-item">
                                        <div class="position-relative border rounded p-1 bg-light">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                 class="img-fluid rounded" 
                                                 style="height: 100px; width: 100%; object-fit: cover;" 
                                                 alt="Image galerie">
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
    // Tableau pour stocker les fichiers images sélectionnés
    let selectedFiles = [];
    
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

    // Gestion des images de la galerie
    $('#images').change(function() {
        const files = Array.from(this.files);
        selectedFiles = files;
        
        const galleryContainer = $('#gallery-container');
        
        if (files.length > 0) {
            $('#gallery-filename').text(`${files.length} fichier(s) sélectionné(s)`);
            galleryContainer.empty();
            $('#no-gallery-message').remove();
            
            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    galleryContainer.append(`
                        <div class="col-4 col-md-3 gallery-item">
                            <div class="position-relative border rounded p-1 bg-light">
                                <img src="${e.target.result}" class="img-fluid rounded" style="height: 100px; width: 100%; object-fit: cover;">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-1 remove-image" data-index="${index}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    `);
                };
                reader.readAsDataURL(file);
            });
        } else {
            resetGallery();
        }
    });

    // Suppression des images dans la prévisualisation
    $(document).on('click', '.remove-image', function() {
        const index = $(this).data('index');
        selectedFiles.splice(index, 1);
        
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        $('#images')[0].files = dataTransfer.files;
        
        $(this).closest('.gallery-item').remove();
        
        if (selectedFiles.length === 0) {
            resetGallery();
        } else {
            $('#gallery-filename').text(`${selectedFiles.length} fichier(s) sélectionné(s)`);
        }
    });

    // Réinitialiser la galerie
    function resetGallery() {
        $('#gallery-container').empty();
        $('#gallery-filename').text('');
        
        @if($product->images->isNotEmpty())
            @foreach($product->images as $image)
                $('#gallery-container').append(`
                    <div class="col-4 col-md-3 gallery-item">
                        <div class="position-relative border rounded p-1 bg-light">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded" style="height: 100px; width: 100%; object-fit: cover;">
                        </div>
                    </div>
                `);
            @endforeach
        @else
            $('#gallery-container').html(`
                <div class="col-12 text-center text-muted py-3" id="no-gallery-message">
                    <i class="fas fa-images fa-2x mb-2"></i>
                    <p class="mb-0">Aucune image supplémentaire</p>
                </div>
            `);
        @endif
    }

    // Afficher une alerte stylisée
    function showAlert(message, type = 'success') {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        `;
        
        // Ajouter au début du conteneur principal
        $('.container.py-5').prepend(alertHtml);
        
        // Fermer automatiquement après 5 secondes
        setTimeout(() => {
            $('.alert').alert('close');
        }, 5000);
    }

    // Soumission du formulaire
    $('#product-edit-form').on('submit', function(e) {
        e.preventDefault();
        
        const $submitBtn = $('#submit-btn');
        $submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> Enregistrement...').prop('disabled', true);
        
        const formData = new FormData(this);
        
        // Ajouter les images sélectionnées
        if (selectedFiles.length > 0) {
            formData.append('replace_gallery', 'true');
            selectedFiles.forEach(file => formData.append('images[]', file));
        }
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showAlert(response.message, 'success');
                    
                    // Redirection après 1.5 secondes
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 1500);
                } else {
                    showAlert(response.message, 'danger');
                    $submitBtn.html('<i class="fas fa-save me-2"></i> Enregistrer').prop('disabled', false);
                }
            },
            error: function(xhr) {
                $submitBtn.html('<i class="fas fa-save me-2"></i> Enregistrer').prop('disabled', false);
                
                let errorMessage = 'Une erreur est survenue. Veuillez réessayer.';
                
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    errorMessage = 'Erreurs de validation:<ul class="mb-0">';
                    
                    Object.values(errors).forEach(error => {
                        errorMessage += `<li>${error[0]}</li>`;
                    });
                    
                    errorMessage += '</ul>';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                showAlert(errorMessage, 'danger');
            }
        });
    });
});
</script>
@endsection