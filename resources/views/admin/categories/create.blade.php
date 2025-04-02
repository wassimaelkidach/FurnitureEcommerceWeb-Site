@extends('layouts.admin')

@section('title', 'Ajouter une catégorie')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-15"> <!-- Largeur réduite à col-md-7 -->
            <div class="card border-0 shadow-sm" style="max-width: 900px; margin: 0 auto;"> <!-- Contrôle de la largeur max -->
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-plus-circle me-2"></i>Nouvelle Catégorie
                        </h5>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-light">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if($errors->any())
                    <div class="alert alert-danger rounded-2 mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Erreurs de validation :</strong>
                        <ul class="mt-2 mb-0 ps-3">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nom de la catégorie -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                            <div class="input-group border rounded-2 overflow-hidden">
                                <span class="input-group-text bg-light-primary border-0">
                                    <i class="bi bi-tag-fill text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-0 py-2" id="name" name="name" placeholder="Ex: Électronique" required>
                            </div>
                        </div>

                        <!-- Upload d'image -->
                        <div class="mb-4">
                            <label for="image" class="form-label fw-semibold">Image</label>
                            <div class="image-upload-container border rounded-3 p-3 text-center" style="min-height: 160px;">
                                <div id="imagePreviewContainer" class="mb-2" style="display:none;">
                                    <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded-2" style="max-height: 180px;">
                                    <button type="button" class="btn btn-sm btn-danger mt-2 px-3" id="removeImage">
                                        <i class="bi bi-trash-fill me-1"></i> Supprimer
                                    </button>
                                </div>
                                <div id="uploadPlaceholder">
                                    <i class="bi bi-images text-muted" style="font-size: 2.2rem;"></i>
                                    <p class="my-2 small">Glissez-déposez une image ou</p>
                                    <label for="image" class="btn btn-sm btn-primary px-3">
                                        <i class="bi bi-upload me-1"></i>Choisir un fichier
                                    </label>
                                    <input type="file" id="image" name="image" accept="image/*" class="d-none">
                                    <p class="small text-muted mt-2 mb-0">JPG, PNG, WEBP (Max 5MB)</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary py-2 rounded-2">
                                <i class="bi bi-check-circle me-1"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Gestion de l'aperçu d'image
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const removeImageBtn = document.getElementById('removeImage');

    imageInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Validation du fichier
            const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Seuls les formats JPG, PNG et WEBP sont acceptés');
                return;
            }
            
            if (file.size > 5 * 1024 * 1024) {
                alert('La taille maximale autorisée est de 5MB');
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreviewContainer.style.display = 'block';
                uploadPlaceholder.style.display = 'none';
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });

    removeImageBtn.addEventListener('click', function() {
        imageInput.value = '';
        imagePreviewContainer.style.display = 'none';
        uploadPlaceholder.style.display = 'block';
    });

    // Drag and drop
    const uploadContainer = document.querySelector('.image-upload-container');
    
    ['dragover', 'dragenter'].forEach(event => {
        uploadContainer.addEventListener(event, (e) => {
            e.preventDefault();
            uploadContainer.classList.add('border-primary', 'bg-light-primary');
        });
    });

    ['dragleave', 'dragend', 'drop'].forEach(event => {
        uploadContainer.addEventListener(event, () => {
            uploadContainer.classList.remove('border-primary', 'bg-light-primary');
        });
    });

    uploadContainer.addEventListener('drop', (e) => {
        e.preventDefault();
        if (e.dataTransfer.files.length) {
            imageInput.files = e.dataTransfer.files;
            const changeEvent = new Event('change');
            imageInput.dispatchEvent(changeEvent);
        }
    });
</script>
@endsection

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    
    .card {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .card-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .bg-light-primary {
        background-color: rgba(13, 110, 253, 0.08) !important;
    }
    
    .image-upload-container {
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }
    
    .image-upload-container:hover {
        background-color: #f1f5f9;
    }
    
    .btn-primary {
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-1px);
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        border-color: #86b7fe;
    }
</style>
@endsection