@extends('layouts.admin')

@section('title', 'Modifier la catégorie')

@section('content')
<div class="container-fluid py-3"> <!-- Changé de py-5 à py-3 pour réduire l'espace en haut -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12"> <!-- Augmenté la largeur avec col-xl-10 -->
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-gradient-primary text-white py-3"> <!-- Réduit le padding de py-4 à py-3 -->
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0 h4"> <!-- Réduit la taille du titre avec h4 -->
                            <i class="bi bi-pencil-square me-2"></i>Modifier la catégorie
                        </h2>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light btn-sm rounded-pill shadow-sm">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>
                </div>

                <div class="card-body p-4 p-lg-5"> <!-- Ajusté le padding pour les différents écrans -->
                    @if($errors->any())
                    <div class="alert alert-light-danger border-3 border-danger rounded-3 mb-4">
                        <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                        <strong>Erreurs de validation :</strong>
                        <ul class="mt-2 mb-0 ps-3">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Nom de la catégorie -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold text-dark">Nom de la catégorie <span class="text-danger">*</span></label>
                            <div class="input-group border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-primary text-white border-0">
                                    <i class="bi bi-tag-fill"></i>
                                </span>
                                <input type="text" class="form-control border-0 py-2" id="name" name="name" value="{{ old('name', $category->name) }}" required placeholder="Entrez le nom de la catégorie">
                            </div>
                        </div>

                        <!-- Image de la catégorie -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Image de la catégorie</label>
                            
                            <div class="row g-4">
                                <!-- Image actuelle -->
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Image actuelle</h6>
                                        </div>
                                        <div class="card-body text-center p-3">
                                            @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="Image actuelle" class="img-fluid rounded-3 shadow" style="max-height: 200px; width: auto;">
                                            @else
                                            <div class="text-muted py-4">
                                                <i class="bi bi-image fs-1"></i>
                                                <p class="mt-2 mb-0">Aucune image</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Nouvelle image -->
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Nouvelle image</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="image-upload-container border-2 border-dashed rounded-4 p-3 text-center position-relative" id="uploadArea">
                                                <input type="file" id="image" name="image" accept="image/*" class="d-none">
                                                
                                                <!-- Aperçu -->
                                                <div class="preview-wrapper" id="previewContainer" style="display: none;">
                                                    <div class="preview-zoom-container rounded-3 overflow-hidden shadow-sm">
                                                        <img src="#" alt="Preview" id="imagePreview" class="preview-image img-fluid w-100 h-auto">
                                                    </div>
                                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle shadow" id="removeBtn">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </div>
                                                
                                                <!-- Zone d'upload -->
                                                <div class="upload-placeholder" id="uploadPlaceholder">
                                                    <div class="icon-container mb-2">
                                                        <i class="bi bi-cloud-arrow-up text-primary" style="font-size: 2rem;"></i>
                                                    </div>
                                                    <h6 class="mb-1 fw-semibold">Glissez-déposez votre image</h6>
                                                    <p class="text-muted mb-2">ou</p>
                                                    <label for="image" class="btn btn-outline-primary rounded-pill px-3 py-1 shadow-sm mb-2" id="browseBtn">
                                                        <i class="bi bi-folder2-open me-2"></i>Parcourir
                                                    </label>
                                                    <p class="small text-muted mt-2 mb-0">Formats: JPG, PNG, WEBP (Max. 5MB)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                                <i class="bi bi-check-circle-fill me-2"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour le zoom d'image -->
<div id="imageZoomModal" class="image-modal">
    <span class="close-modal">&times;</span>
    <div class="modal-content-wrapper">
        <img class="modal-content" id="zoomedImage">
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de l'upload d'image
        const imageInput = document.getElementById('image');
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const browseBtn = document.getElementById('browseBtn');
        const removeBtn = document.getElementById('removeBtn');
        const uploadArea = document.getElementById('uploadArea');
        
        // Correction du problème de clic sur Parcourir
        browseBtn.addEventListener('click', function(e) {
            e.stopPropagation(); // Empêche la propagation de l'événement
            imageInput.click();
        });

        // Gestion du changement de fichier
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                
                if (file.size > 5 * 1024 * 1024) {
                    alert('Le fichier est trop volumineux (max 5MB)');
                    return;
                }
                
                const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Format de fichier non supporté');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.style.display = 'block';
                    uploadPlaceholder.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });

        // Gestion de la suppression de l'image
        removeBtn.addEventListener('click', function() {
            imageInput.value = '';
            previewContainer.style.display = 'none';
            uploadPlaceholder.style.display = 'block';
        });

        // Drag and drop
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.add('border-primary', 'bg-light-primary');
        }

        function unhighlight(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.remove('border-primary', 'bg-light-primary');
            
            if (e.type === 'drop') {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length) {
                    imageInput.files = files;
                    const event = new Event('change');
                    imageInput.dispatchEvent(event);
                }
            }
        }

        // Gestion du zoom sur l'image actuelle
        const currentImage = document.querySelector('.card-body img');
        if (currentImage) {
            currentImage.addEventListener('click', function() {
                if(this.src.includes('storage/')) {
                    const modal = document.getElementById("imageZoomModal");
                    const modalImg = document.getElementById("zoomedImage");
                    modal.style.display = "flex";
                    modalImg.src = this.src;
                    modalImg.classList.remove('zoomed');
                }
            });
        }

        // Gestion du zoom sur l'aperçu
        imagePreview.addEventListener('click', function() {
            const modal = document.getElementById("imageZoomModal");
            const modalImg = document.getElementById("zoomedImage");
            modal.style.display = "flex";
            modalImg.src = this.src;
            modalImg.classList.remove('zoomed');
        });

        // Basculer le zoom
        document.getElementById("zoomedImage").addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('zoomed');
        });

        // Fermer le modal
        document.getElementsByClassName("close-modal")[0].addEventListener('click', function() {
            document.getElementById("imageZoomModal").style.display = "none";
        });

        document.getElementById("imageZoomModal").addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = "none";
            }
        });
    });
</script>
@endsection

@section('styles')
<style>
    /* Styles de base */
    body {
        background-color: #f8fafc;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
    }
    
    /* Carte principale - Augmentation de la largeur */
    .card {
        border: none;
        overflow: hidden;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .card-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    /* Zone d'upload */
    .image-upload-container {
        min-height: 180px;
        border-color: #dee2e6 !important;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .bg-light-primary {
        background-color: rgba(59, 130, 246, 0.08) !important;
    }
    
    .border-dashed {
        border-style: dashed !important;
    }
    
    /* Prévisualisation */
    .preview-zoom-container {
        height: 150px;
        overflow: hidden;
    }
    
    /* Boutons */
    .btn {
        transition: all 0.2s ease;
    }
    
    .btn-primary {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
    
    .btn-primary:hover {
        background-color: #2563eb;
        border-color: #2563eb;
        transform: translateY(-1px);
    }
    
    /* Modal de zoom */
    .image-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }
    
    .modal-content-wrapper {
        width: 100%;
        max-width: 90vw;
        max-height: 90vh;
        position: relative;
    }
    
    .modal-content {
        width: 100%;
        height: auto;
        max-height: 90vh;
        object-fit: contain;
        border-radius: 8px;
        transition: transform 0.3s ease;
        cursor: zoom-in;
    }
    
    .modal-content.zoomed {
        transform: scale(1.5);
        cursor: zoom-out;
    }
    
    .close-modal {
        position: absolute;
        top: 20px;
        right: 20px;
        color: white;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
        z-index: 10000;
        background: rgba(0, 0, 0, 0.5);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    
    .close-modal:hover {
        background: rgba(0, 0, 0, 0.7);
        transform: scale(1.1);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .modal-content-wrapper {
            max-width: 95%;
            max-height: 70vh;
        }
        
        .close-modal {
            top: 10px;
            right: 10px;
            font-size: 24px;
            width: 36px;
            height: 36px;
        }
    }
</style>
@endsection