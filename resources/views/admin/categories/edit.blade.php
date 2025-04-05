@extends('layouts.admin')

@section('title', 'Modifier la catégorie')

@section('content')
<div class="container-fluid py-9 px-10">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-tags-fill text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h1 class="h3 mb-0 text-dark">Modification de catégorie</h1>
                        <p class="text-muted mb-0">Ajouter une nouvelle catégorie de produits</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section formulaire élargie -->
    <div class="row justify-content-center">
        <div class="col-xl-12 col-xxl-12">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5 bg-white">
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
                            <div class="input-group border rounded-3 overflow-hidden shadow-sm">
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
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="Image actuelle" class="img-fluid rounded-3 shadow" style="max-height: 220px; width: auto;">
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
                                            <div class="image-upload-container border-2 border-dashed rounded-4 p-3 text-center position-relative" id="uploadArea" style="min-height: 220px;">
                                                <input type="file" id="image" name="image" accept="image/*" class="d-none">
                                                
                                                <div class="preview-wrapper" id="previewContainer" style="display: none;">
                                                    <div class="preview-zoom-container rounded-3 overflow-hidden shadow-sm" style="height: 180px;">
                                                        <img src="#" alt="Preview" id="imagePreview" class="preview-image img-fluid w-100 h-100 object-fit-cover">
                                                    </div>
                                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle shadow" id="removeBtn">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </div>
                                                
                                                <div class="upload-placeholder" id="uploadPlaceholder">
                                                    <div class="icon-container mb-2">
                                                        <i class="bi bi-cloud-arrow-up text-primary" style="font-size: 2.2rem;"></i>
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

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top gap-3">
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4 rounded-pill fw-medium">
        <i class="fas fa-arrow-left me-2"></i> Annuler
    </a>
    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm fw-medium gradient-btn">
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
    <img class="modal-content" id="zoomedImage">
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
        
        // Gestion du clic sur Parcourir
        browseBtn.addEventListener('click', function(e) {
            e.stopPropagation();
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
    body {
        background-color: #f8f9fa;
    }
    
    /* Conteneur principal élargi */
    .container-fluid {
        max-width: 1800px;
    }
    
    /* Carte formulaire */
    .card {
        border-radius: 1rem;
        overflow: hidden;
    }
    
    .shadow-lg {
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15) !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 1.5rem 3rem rgba(0, 0, 0, 0.2) !important;
    }
    
    /* Champs de formulaire */
    .input-group {
        transition: all 0.3s ease;
    }
    
    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    
    /* Zone d'upload */
    .image-upload-container {
        background-color: #f8fafc;
        transition: all 0.3s ease;
        border-color: #dee2e6 !important;
    }
    
    .image-upload-container:hover {
        background-color:rgb(144, 153, 161);
        border-color: #3b82f6 !important;
    }
    
    .border-dashed {
        border-style: dashed !important;
    }
    
    /* Boutons */
    .btn-primary {
        background-color: #3b82f6;
        border-color: #3b82f6;
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        background-color: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    /* Modal zoom */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.95);
        align-items: center;
        justify-content: center;
    }
    
    .modal-content {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        cursor: zoom-in;
        transition: transform 0.3s ease;
    }
    
    .modal-content.zoomed {
        transform: scale(1.5);
        cursor: zoom-out;
    }
    
    .close-modal {
        position: absolute;
        top: 25px;
        right: 40px;
        color: white;
        font-size: 45px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .close-modal:hover {
        color: #f8f9fa;
        transform: scale(1.1);
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .container-fluid {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        
        .col-xl-10 {
            width: 100%;
        }
    }
    
    @media (max-width: 768px) {
        .image-upload-container {
            min-height: 180px;
        }
        
        .close-modal {
            top: 15px;
            right: 25px;
            font-size: 35px;
        }
    }
</style>
@endsection