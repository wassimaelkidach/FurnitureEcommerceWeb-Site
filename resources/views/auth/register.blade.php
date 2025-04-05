<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>
<body>
    <div class="background-blur"></div>
    <div class="container">
        <div class="box form-box">
            <header>S'inscrire</header>
            <!-- Affichage des erreurs de validation -->

            @if($errors->any())
                <div style="color: red;">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Formulaire d'inscription -->
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" id="signupForm">
                @csrf

                <!-- Champ nom -->
                <div class="field input">
                    <input type="text" name="name" required id="Username" placeholder="Nom d'utilisateur">
                </div>

                <!-- Champ email -->
                <div class="field input">
                    <input type="email" id="email" name="email" required placeholder="Email">
                </div>

                <!-- Champ mot de passe -->
                <div class="field input">
                    <div class="pass">
                        <input type="password" name="password" required placeholder="Mot de passe" id="logPassword">
                        <span class="password-toggle" onclick="togglePassword()">Afficher</span>
                    </div>    
                </div>
            
                <!-- Champ confirmation du mot de passe -->
                <div class="field input">
                    <div class="pass">
                        <input type="password" name="password_confirmation" required placeholder="Confirmer le mot de passe" id="logPassword">
                        <span class="password-toggle" onclick="togglePassword()">Afficher</span>
                    </div>
                </div>

                <!-- Champ téléphone -->
                <div class="field input">
                    <input type="text" name="phone" required placeholder="Numéro de téléphone">
                </div>

                <!-- Champ date de naissance -->
                <div class="field input">
                    <label for="birthday">Date de naissance</label>
                    <input type="date" name="birthday" required>
                </div>

                <!-- Champ image -->
                <div class="field input">
                    <label for="image">Photo de profil</label>
                    <input type="file" name="image" accept="image/*">
                </div>

                <div class="field">
                    <button type="submit" class="btn">S'inscrire</button>
                </div>
            </form>

            <p>Déjà membre ? <a href="{{ route('login') }}" class="sign">Connectez-vous ici !</a></p>
        </div>
    </div>
</body>
</html>