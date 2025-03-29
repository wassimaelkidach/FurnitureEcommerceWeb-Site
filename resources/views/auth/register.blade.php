@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Inscription</h1>

        <!-- Affichage des erreurs de validation -->
        @if($errors->any())
            <div style="color: red;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Formulaire d'inscription -->
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Champ nom -->
            <div>
                <label for="name">Nom</label>
                <input type="text" name="name" required>
            </div>

            <!-- Champ email -->
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" required>
            </div>

            <!-- Champ mot de passe -->
            <div>
                <label for="password">Mot de passe</label>
                <input type="password" name="password" required>
            </div>

            <!-- Champ confirmation du mot de passe -->
            <div>
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit">S'inscrire</button>
        </form>

        <p>Vous avez déjà un compte ? <a href="{{ route('login') }}">Connectez-vous ici</a></p>
    </div>
@endsection
