@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Se connecter</h1>

        <!-- Affichage des erreurs de validation -->
        @if($errors->any())
            <div style="color: red;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Formulaire de connexion -->
        <form action="{{ route('login') }}" method="POST">
            @csrf

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

            <button type="submit">Se connecter</button>
        </form>

        <p>Pas encore inscrit ? <a href="{{ route('register') }}">Inscrivez-vous ici</a></p>
    </div>
@endsection
