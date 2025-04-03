<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">

</head>
<body>
    <div class="background-blur"></div>
    <div class="container">
        <div class="box form-box">
            <header>Sign Up</header>
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
                    <input type="text" name="name" required id="Username" placeholder="username">
                </div>

                <!-- Champ email -->
                <div class="field input">
                    <input type="email" id="email" name="email" required placeholder="Email">
                </div>

                <!-- Champ mot de passe -->
                <div class="field input">
                    <div class="pass">
                        <input type="password" name="password" required placeholder="Password" id="logPassword">
                        <span class="password-toggle" onclick="togglePassword()">Show</span>
                    </div>    
                </div>
            
                <!-- Champ confirmation du mot de passe -->
                <div class="field input">
                    <div class="pass">
                        <input type="password" name="password_confirmation" required placeholder="Confirm Password" id="logPassword">
                        <span class="password-toggle" onclick="togglePassword()">Show</span>
                    </div>
                    
                </div>

                <!-- Champ téléphone -->
                <div class="field input">
                    <input type="text" name="phone" required placeholder="Phone number">
                </div>

                <!-- Champ date de naissance -->
                <div class="field input">
                    <label for="birthday">Birthday date</label>
                    <input type="date" name="birthday" required>
                </div>

                <!-- Champ image -->
                <div class="field input">
                    <label for="image">profil picture</label>
                    <input type="file" name="image" accept="image/*">
                </div>

                <div class="field">
                    <button type="submit" class="btn">Sign up</button>
                </div>
            </form>

            <p>Already a member? <a href="{{ route('login') }}" class="sign">Sign In here !</a></p>
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

