@extends('layouts.app')

@section('content')
    <div class="profile-container">
        <div class="profile-card">
            <!-- Section d'affichage du profil -->
            <div class="profile-header">
                @if($user->profile_image)
                    <div class="profile-avatar">
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Image de profil">
                    </div>
                @else
                    <div class="profile-avatar default">
                        <span>{{ substr($user->name, 0, 1) }}</span>
                    </div>
                @endif
                
                <h1 class="profile-title">{{ $user->name }}</h1>
                <div class="profile-meta">
                    <span><i class="fas fa-envelope"></i> {{ $user->email }}</span>
                    @if($user->birthday)
                        <span><i class="fas fa-birthday-cake"></i> {{ $user->birthday }}</span>
                    @endif
                    @if($user->phone)
                        <span><i class="fas fa-phone"></i> {{ $user->phone }}</span>
                    @endif
                </div>
            </div>

            <!-- Messages flash -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulaire de mise à jour -->
            <div class="profile-form">
                <h2><i class="fas fa-user-edit"></i> Modifier votre profil</h2>
                
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="birthday">Date de naissance</label>
                            <input type="date" name="birthday" value="{{ old('birthday', $user->birthday) }}">
                        </div>

                        <div class="form-group">
                            <label for="phone">Téléphone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    /* Style général */
    .profile-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .profile-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    /* En-tête du profil */
    .profile-header {
        background: linear-gradient(135deg, #DCE7E6, #518581);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 1rem;
        overflow: hidden;
        border: 4px solid rgba(255, 255, 255, 0.3);
    }

    .profile-avatar.default {
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: bold;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-title {
        margin: 0.5rem 0;
        font-size: 1.8rem;
    }

    .profile-meta {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .profile-meta span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Formulaire */
    .profile-form {
        padding: 2rem;
    }

    .profile-form h2 {
        color: #444;
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-row {
        display: flex;
        gap: 1.5rem;
    }

    .form-row .form-group {
        flex: 1;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        color: #555;
        font-weight: 500;
    }

    input[type="text"],
    input[type="date"],
    input[type="email"] {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1rem;
        transition: border 0.3s;
    }

    input:focus {
        border-color: #6e8efb;
        outline: none;
    }

    /* Bouton d'upload personnalisé */
    .file-upload label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1.2rem;
        background: #f5f7fa;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .file-upload label:hover {
        background: #e6e9f0;
    }

    .file-upload input[type="file"] {
        display: none;
    }

    /* Bouton de soumission */
    .btn-primary {
        background:  #4CAF50;
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(106, 118, 251, 0.3);
    }

    /* Message d'alerte */
    .alert {
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }
        
        .profile-meta {
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
        }
    }
</style>