@extends('layouts.app')

@section('content')
<div class="profile-container">
    <!-- En-tête du profil -->
    <div class="profile-header">
        <div class="profile-header-content">
            <div class="profile-image-wrapper">
                @if($user->profile_image)
                <div class="profile-image-container">
                    <img src="{{ asset('storage/' . $user->profile_image) }}" 
                         alt="Photo de profil">
                    <div class="profile-image-overlay">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
                @endif
            </div>
            <div class="profile-info">
                <h1>{{ $user->name }}</h1>
                <p class="profile-email">
                    <i class="fas fa-envelope"></i>{{ $user->email }}
                </p>
                <div class="profile-badges">
                    @if($user->birthday)
                    <span class="profile-badge">
                        <i class="fas fa-birthday-cake"></i> 
                        {{ \Carbon\Carbon::parse($user->birthday)->format('d/m/Y') }}
                    </span>
                    @endif
                    @if($user->phone)
                    <span class="profile-badge">
                        <i class="fas fa-phone"></i> {{ $user->phone }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-message success">
        {{ session('success') }}
        <button type="button" class="alert-close">&times;</button>
    </div>
    @endif

    <div class="profile-content">
        <!-- Section Formulaire -->
        <div class="profile-form-section">
            <div class="profile-form-card">
                <div class="form-card-header">
                    <h3>
                        <i class="fas fa-user-edit"></i>
                        Modifier le profil
                    </h3>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name">Nom complet</label>
                                <div class="input-wrapper">
                                    <span class="input-icon">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" id="name" name="name" 
                                           value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="birthday">Date de naissance</label>
                                <div class="input-wrapper">
                                    <span class="input-icon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <input type="date" id="birthday" name="birthday" 
                                           value="{{ old('birthday', $user->birthday) }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone">Téléphone</label>
                                <div class="input-wrapper">
                                    <span class="input-icon">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="text" id="phone" name="phone" 
                                           value="{{ old('phone', $user->phone) }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="profile_image">Photo de profil</label>
                                <div class="file-input-wrapper">
                                    <span class="input-icon">
                                        <i class="fas fa-image"></i>
                                    </span>
                                    <input type="file" id="profile_image" name="profile_image" accept="image/*">
                                    <span class="file-input-label">Aucun fichier sélectionné</span>
                                </div>
                                <small>Formats acceptés: JPG, PNG (max 2MB)</small>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="submit-button">
                                <i class="fas fa-save"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Section Statistiques -->
        <div class="profile-stats-section">
            <div class="stats-card">
                <div class="stats-card-header">
                    <h3>
                        <i class="fas fa-chart-pie"></i>
                        Activité
                    </h3>
                </div>
                <div class="stats-card-body">
                    <div class="stats-content">
                        <div class="stat-item">
                            <div class="stat-header">
                                <span>Membre depuis</span>
                                <span class="stat-value">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 100%"></div>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-header">
                                <span>Profil complété</span>
                                <span class="stat-value">@php echo rand(70, 95); @endphp%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: @php echo rand(70, 95); @endphp%"></div>
                            </div>
                        </div>

                        <div class="stats-footer">
                            <button class="history-button">
                                <i class="fas fa-history"></i>Voir l'historique
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Variables */
    :root {
        --primary-color: #3498db;
        --secondary-color: #2980b9;
        --success-color: #2ecc71;
        --light-color: #ecf0f1;
        --dark-color: #2c3e50;
        --text-color: #333;
        --text-muted: #7f8c8d;
        --border-radius: 8px;
        --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    /* Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        line-height: 1.6;
        color: var(--text-color);
        background-color: #f5f7fa;
    }

    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Profile Header */
    .profile-header {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: var(--box-shadow);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .profile-header-content {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 30px;
    }

    .profile-image-wrapper {
        flex: 0 0 120px;
    }

    .profile-info {
        flex: 1;
        min-width: 0;
    }

    .profile-image-container {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
        margin: 0 auto;
        border: 4px solid white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .profile-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .profile-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(52, 152, 219, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 0;
        transition: var(--transition);
    }

    .profile-image-container:hover .profile-image-overlay {
        opacity: 1;
    }

    .profile-image-container:hover img {
        transform: scale(1.1);
    }

    .profile-info h1 {
        font-size: 2.2rem;
        color: var(--dark-color);
        margin-bottom: 10px;
    }

    .profile-email {
        font-size: 1.1rem;
        color: var(--text-muted);
        margin-bottom: 15px;
    }

    .profile-email i {
        margin-right: 8px;
    }

    .profile-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .profile-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        background: var(--light-color);
        border-radius: 20px;
        font-size: 0.9rem;
        color: var(--dark-color);
    }

    .profile-badge i {
        margin-right: 5px;
    }

    /* Alert Message */
    .alert-message {
        padding: 15px;
        border-radius: var(--border-radius);
        margin-bottom: 30px;
        position: relative;
    }

    .alert-message.success {
        background: rgba(46, 204, 113, 0.2);
        border: 1px solid var(--success-color);
        color: #27ae60;
    }

    .alert-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: var(--text-muted);
    }

    /* Profile Content */
    .profile-content {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }

    .profile-form-section {
        flex: 2;
        min-width: 0;
    }

    .profile-stats-section {
        flex: 1;
        min-width: 0;
    }

    /* Form Card */
    .profile-form-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--box-shadow);
        overflow: hidden;
        transition: var(--transition);
    }

    .profile-form-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .form-card-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
    }

    .form-card-header h3 {
        font-size: 1.4rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-card-body {
        padding: 20px;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .input-wrapper {
        display: flex;
        margin-bottom: 15px;
    }

    .input-icon {
        padding: 10px 15px;
        background: var(--light-color);
        border: 1px solid #ddd;
        border-right: none;
        border-radius: var(--border-radius) 0 0 var(--border-radius);
        color: var(--text-muted);
    }

    .input-wrapper input {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-left: none;
        border-radius: 0 var(--border-radius) var(--border-radius) 0;
        font-size: 1rem;
    }

    .input-wrapper input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
    }

    /* File Input */
    .file-input-wrapper {
        position: relative;
        display: flex;
        margin-bottom: 15px;
    }

    .file-input-wrapper input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-input-label {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-left: none;
        border-radius: 0 var(--border-radius) var(--border-radius) 0;
        background: white;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .form-group small {
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .submit-button {
        padding: 10px 25px;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .submit-button:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(41, 128, 185, 0.3);
    }

    /* Stats Card */
    .stats-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--box-shadow);
        height: 100%;
    }

    .stats-card-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
    }

    .stats-card-header h3 {
        font-size: 1.4rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stats-card-body {
        padding: 20px;
    }

    .stat-item {
        margin-bottom: 20px;
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .stat-value {
        font-weight: 600;
    }

    .progress-bar {
        height: 6px;
        background: var(--light-color);
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-color), var(--success-color));
        border-radius: 3px;
        transition: width 0.6s ease;
    }

    .stats-footer {
        text-align: center;
        margin-top: 30px;
    }

    .history-button {
        padding: 8px 20px;
        background: transparent;
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
        border-radius: 50px;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .history-button:hover {
        background: rgba(52, 152, 219, 0.1);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .profile-content {
            flex-direction: column;
        }
        
        .profile-form-section,
        .profile-stats-section {
            flex: 1 1 100%;
        }
    }

    @media (max-width: 768px) {
        .profile-header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .profile-badges {
            justify-content: center;
        }
        
        .profile-image-wrapper {
            flex: 0 0 auto;
        }
        
        .profile-info h1 {
            font-size: 1.8rem;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .profile-header {
            padding: 20px;
        }
        
        .profile-image-container {
            width: 80px;
            height: 80px;
        }
        
        .input-wrapper,
        .file-input-wrapper {
            flex-direction: column;
        }
        
        .input-icon {
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            border-right: 1px solid #ddd;
            border-bottom: none;
        }
        
        .input-wrapper input {
            border-radius: 0 0 var(--border-radius) var(--border-radius);
            border-left: 1px solid #ddd;
            border-top: none;
        }
        
        .file-input-label {
            border-left: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }
    }
</style>

<script>
    document.getElementById('profile_image').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Aucun fichier sélectionné';
        document.querySelector('.file-input-label').textContent = fileName;
    });
</script>
@endsection