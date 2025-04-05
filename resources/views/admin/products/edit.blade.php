@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Modifier le produit</h1>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div>
                <label for="name">Nom</label>
                <input type="text" name="name" value="{{ $product->name }}" id="name" required>
            </div>
            <div>
                <label for="description">Description</label>
                <textarea name="description" id="description" required>{{ $product->description }}</textarea>
            </div>
            <div>
                <label for="price">Prix</label>
                <input type="number" name="price" value="{{ $product->price }}" id="price" required>
            </div>
            <div>
                <label for="main_image">Image principale</label>
                <input type="file" name="main_image" id="main_image">
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
            <button type="submit">Mettre à jour le produit</button>
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