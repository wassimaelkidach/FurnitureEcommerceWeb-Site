@extends('layouts.app')

@section('title','login')

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
    </head>
    <body>
    <div class="background-blur"></div>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>

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
                        <input type="email" name="email" placeholder="Email" required>                        <i class='bx bxs-user'></i>
                        <span></span>
                    </div>
                </div>

                <!-- Champ mot de passe -->
                <div class="field input">
                    <div class="pass">
                    <input type="password" name="password" placeholder="Password" id="logPassword" required>
                    <span class="password-toggle" onclick="togglePassword()">Show</span>
                </div>
                

                <div class="field">
                    <button type="submit" class="btn">Login</button>
                </div>

                <div class="links">
                    <p>Don't have an account? <a href="{{ route('register') }}" class="sign">Sign Up Now !</a></p>
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
                toggleText.textContent = "Hide";
            } else {
                passwordField.type = "password";
                toggleText.textContent = "Show";
            }
        }
        
    </script>
</body>
</html>
