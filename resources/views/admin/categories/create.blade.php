@extends('layouts.admin')

@section('title', 'Ajouter une catégorie')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                    <i class="bi bi-tags-fill text-primary" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <h1 class="h3 mb-0 text-dark">Création de catégorie</h1>
                    <p class="text-muted mb-0">Ajouter une nouvelle catégorie de produits</p>
                </div>
            </div>
            <!-- <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
            </a> -->
        </div>
    </div>
</div>
    <!-- Section blanche avec ombre - Largeur augmentée -->
    <div class="row justify-content-center">
        <div class="col-lg-12 col-xl-12"> <!-- Augmentation de la largeur -->
            <div class="bg-white rounded-3 shadow-lg p-4 p-lg-5">
                <div class="card-body p-0">
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

                        <!-- Nom de la catégorie - Largeur augmentée -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                            <div class="input-group border rounded-2 overflow-hidden">
                                <span class="input-group-text bg-light-primary border-0">
                                    <i class="bi bi-tag-fill text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-0 py-2" id="name" name="name" placeholder="Ex: Électronique" required>
                            </div>
                        </div>

                        <!-- Upload d'image - Largeur augmentée -->
                        <div class="mb-4">
                            <label for="image" class="form-label fw-semibold">Image</label>
                            <div class="image-upload-container border rounded-3 p-3 text-center" style="min-height: 160px;">
                                <div id="imagePreviewContainer" class="mb-2" style="display:none;">
                                    <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded-2" style="max-height: 200px;"> <!-- Hauteur augmentée -->
                                    <button type="button" class="btn btn-sm btn-danger mt-2 px-3" id="removeImage">
                                        <i class="bi bi-trash-fill me-1"></i> Supprimer
                                    </button>
                                </div>
                                <div id="uploadPlaceholder">
                                    <i class="bi bi-images text-muted" style="font-size: 2.5rem;"></i> <!-- Taille icône augmentée -->
                                    <p class="my-2">Glissez-déposez une image ou</p> <!-- Texte légèrement agrandi -->
                                    <label for="image" class="btn btn-sm btn-primary px-4"> <!-- Bouton légèrement élargi -->
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