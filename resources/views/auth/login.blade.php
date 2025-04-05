<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>
<body>
<div class="background-blur"></div>
<div class="container">
    <div class="box form-box">
        <header>Connexion</header>

        <!-- Affichage des erreurs de validation -->
        @if($errors->any())
        <div style="color: red;">
            @foreach($errors->all() as $error)
               <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <!-- Formulaire de connexion -->
        <form action="{{ route('login') }}" method="POST" id="logForm">
           @csrf
            <!-- Champ email -->
            <div class="field input">
                <div class="em">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-user'></i>
                    <span></span>
                </div>
            </div>

            <!-- Champ mot de passe -->
            <div class="field input">
                <div class="pass">
                <input type="password" name="password" placeholder="Mot de passe" id="logPassword" required>
                <span class="password-toggle" onclick="togglePassword()">Afficher</span>
            </div>
            

            <div class="field">
                <button type="submit" class="btn">Se connecter</button>
            </div>

            <div class="links">
                <p>Vous n'avez pas de compte ? <a href="{{ route('register') }}" class="sign">Inscrivez-vous !</a></p>
            </div>
        </form>

    </div>
    
</div>
<script>

    document.getElementById('logForm').addEventListener('submit', formSubmit);
    function togglePassword() {
        const passwordField = document.getElementById('logPassword');
        const toggleText = document.querySelector('.password-toggle');

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleText.textContent = "Masquer";
        } else {
            passwordField.type = "password";
            toggleText.textContent = "Afficher";
        }
    }
    
</script>
</body>
</html>