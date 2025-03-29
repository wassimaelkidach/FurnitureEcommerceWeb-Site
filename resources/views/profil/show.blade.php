@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Profil de {{ $user->name }}</h1>

        @if(session('success'))
            <div style="color: green;">{{ session('success') }}</div>
        @endif

        <p>Email: {{ $user->email }}</p>
        <p>Date de naissance: {{ $user->birthday }}</p>
        <p>Numéro de téléphone: {{ $user->phone }}</p>

        <h3>Modifier votre profil</h3>

        <!-- Formulaire de mise à jour du profil -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Champ pour le nom -->
            <div>
                <label for="name">Nom :</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <!-- Champ pour la date de naissance -->
            <div>
                <label for="birthday">Date de naissance :</label>
                <input type="date" name="birthday" value="{{ old('birthday', $user->birthday) }}">
            </div>

            <!-- Champ pour le téléphone -->
            <div>
                <label for="phone">Téléphone :</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
            </div>

            <!-- Champ pour l'image de profil -->
            <div>
                <label for="profile_image">Image de profil :</label>
                <input type="file" name="profile_image" accept="image/*">
            </div>

            <button type="submit">Mettre à jour le profil</button>
        </form>

        <!-- Afficher l'image de profil -->
        @if($user->profile_image)
            <div>
                <h3>Votre image de profil :</h3>
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Image de profil" style="max-width: 200px;">
            </div>
        @endif
    </div>
@endsection
