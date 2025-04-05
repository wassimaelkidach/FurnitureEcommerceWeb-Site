@extends('layouts.admin')

@section('title', 'Ajouter un produit')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="fas fa-box text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h1 class="h3 mb-0 text-dark">Création du produit</h1>
                        <p class="text-muted mb-0">Remplissez les détails de votre nouveau produit</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section blanche avec ombre -->
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="bg-white rounded-4 shadow-lg p-4 p-lg-5 mb-5">
                <!-- Affichage des erreurs de validation -->
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 border-3 border-danger">
                        <h5 class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-2"></i>Erreurs de validation
                        </h5>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulaire d'ajout de produit -->
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Colonne gauche -->
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="name" class="form-label fw-bold">Nom du produit <span class="text-danger">*</span></label>
                                <input type="text" class="form-control border-2 py-2" id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="Entrez le nom du produit" required>
                            </div>

                            <div class="mb-4">
                                <label for="price" class="form-label fw-bold">Prix <span class="text-danger">*</span></label>
                                <div class="input-group border-2 rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-primary text-white border-0">DH</span>
                                    <input type="number" step="0.01" class="form-control border-0 py-2" id="price" name="price" 
                                           value="{{ old('price') }}" placeholder="0.00" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="quantity" class="form-label fw-bold">Quantité <span class="text-danger">*</span></label>
                                <input type="number" class="form-control border-2 py-2" id="quantity" name="quantity" 
                                       value="{{ old('quantity') }}" required>
                            </div>
                        </div>
                        
                        <!-- Colonne droite -->
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control border-2" id="description" name="description" rows="8" 
                                          placeholder="Décrivez le produit en détail..." required>{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="colors" class="form-label fw-bold">Couleurs disponibles</label>
                                <select name="colors[]" id="colors" class="form-control border-2" multiple>
                                    @foreach($colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section Catégorie -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <label for="category_id" class="form-label fw-bold">Catégorie <span class="text-danger">*</span></label>
                                <select class="form-select border-2 py-2" id="category_id" name="category_id" required>
                                    <option value="" disabled selected>Sélectionnez une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Ligne des images MODIFIÉE -->
                    <div class="row mt-2">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="image" class="form-label fw-bold">Image principale <span class="text-danger">*</span></label>
                                <div class="file-upload-container border-2 border-dashed rounded-4 p-4 text-center">
                                    <input class="form-control d-none" type="file" id="image" name="image" required>
                                    <label for="image" class="btn btn-outline-primary rounded-pill px-4 py-2 shadow-sm">
                                        <i class="fas fa-cloud-upload-alt me-2"></i> Choisir un fichier
                                    </label>
                                    <div id="image-info" class="form-text mt-2 text-primary fw-semibold"></div>
                                    <div class="form-text">Formats acceptés : JPEG, PNG (Max 5MB)</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="images" class="form-label fw-bold">Images supplémentaires</label>
                                <div class="file-upload-container border-2 border-dashed rounded-4 p-4 text-center">
                                    <input class="form-control d-none" type="file" id="images" name="images[]" multiple>
                                    <label for="images" class="btn btn-outline-primary rounded-pill px-4 py-2 shadow-sm">
                                        <i class="fas fa-images me-2"></i> Choisir des fichiers
                                    </label>
                                    <div id="gallery-info" class="form-text mt-2 text-primary fw-semibold"></div>
                                    <div class="form-text">Sélectionnez plusieurs images (Max 10MB au total)</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Retour à la liste
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image principale
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const infoElement = document.getElementById('image-info');
            
            if (file) {
                infoElement.innerHTML = `
                    <i class="fas fa-check-circle text-success me-1"></i>
                    ${file.name}
                `;
            } else {
                infoElement.innerHTML = '';
            }
        });
        
        // Images multiples
        document.getElementById('images').addEventListener('change', function(e) {
            const files = e.target.files;
            const infoElement = document.getElementById('gallery-info');
            
            if (files.length > 0) {
                if (files.length === 1) {
                    infoElement.innerHTML = `
                        <i class="fas fa-check-circle text-success me-1"></i>
                        1 fichier sélectionné: ${files[0].name}
                    `;
                } else {
                    infoElement.innerHTML = `
                        <i class="fas fa-check-circle text-success me-1"></i>
                        ${files.length} fichiers sélectionnés
                    `;
                }
            } else {
                infoElement.innerHTML = '';
            }
        });
    });
</script>
@endsection