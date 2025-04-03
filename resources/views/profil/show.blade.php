@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header avec effet de verre (glassmorphism) -->
    <div class="glass-card p-4 mb-5 rounded-4 shadow">
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                @if($user->profile_image)
                <div class="profile-img-container">
                    <img src="{{ asset('storage/' . $user->profile_image) }}" 
                         class="img-fluid rounded-circle border border-4 border-white shadow" 
                         alt="Photo de profil">
                    <div class="profile-overlay rounded-circle">
                        <i class="fas fa-camera text-white"></i>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-md-10">
                <h1 class="display-5 fw-bold text-primary">{{ $user->name }}</h1>
                <p class="lead text-muted">
                    <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                </p>
                <div class="d-flex flex-wrap gap-3">
                    @if($user->birthday)
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-birthday-cake me-1"></i> 
                        {{ \Carbon\Carbon::parse($user->birthday)->format('d/m/Y') }}
                    </span>
                    @endif
                    @if($user->phone)
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-phone me-1"></i> {{ $user->phone }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Section Formulaire -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 rounded-top-4">
                    <h3 class="h5 mb-0">
                        <i class="fas fa-user-edit text-primary me-2"></i>
                        Modifier le profil
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nom complet</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-user text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="birthday" class="form-label">Date de naissance</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                    </span>
                                    <input type="date" class="form-control" id="birthday" name="birthday" 
                                           value="{{ old('birthday', $user->birthday) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Téléphone</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-phone text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control" id="phone" name="phone" 
                                           value="{{ old('phone', $user->phone) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="profile_image" class="form-label">Photo de profil</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-image text-primary"></i>
                                    </span>
                                    <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                                </div>
                                <small class="text-muted">Formats acceptés: JPG, PNG (max 2MB)</small>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Section Statistiques (créative) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 rounded-top-4">
                    <h3 class="h5 mb-0">
                        <i class="fas fa-chart-pie text-primary me-2"></i>
                        Activité
                    </h3>
                </div>
                <div class="card-body">
                    <div class="activity-stats">
                        <div class="stat-item mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Membre depuis</span>
                                <span class="fw-bold">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-primary" role="progressbar" 
                                     style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="stat-item mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Profil complété</span>
                                <span class="fw-bold">@php echo rand(70, 95); @endphp%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: @php echo rand(70, 95); @endphp%" 
                                     aria-valuenow="@php echo rand(70, 95); @endphp" 
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-outline-primary rounded-pill px-4">
                                <i class="fas fa-history me-2"></i>Voir l'historique
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        background-image: linear-gradient(to right, #f8f9fa, #e9f5ff);
    }
    
    .profile-img-container {
        position: relative;
        width: fit-content;
        margin: 0 auto;
    }
    
    .profile-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .profile-img-container:hover .profile-overlay {
        opacity: 1;
    }
    
    .card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .stat-item {
        padding: 0 10px;
    }
    
    .rounded-4 {
        border-radius: 1rem !important;
    }
</style>
@endsection