<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // Afficher le formulaire de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Gérer l'authentification
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home');  // Rediriger vers la page d'accueil après la connexion
        }
    
        return back()->withErrors(['email' => 'Les informations de connexion sont incorrectes.']);
    }
    
    
    // Afficher le formulaire d'inscription
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Gérer l'inscription
    public function register(Request $request)
    {
        $request->validate([
            'name'          => 'required|max:255',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6|confirmed',
            'birthday'      => 'required|date',
            'phone'         => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        // Gestion de l'upload de l'image de profil
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }
    
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'birthday'      => $request->birthday,
            'phone'         => $request->phone,
            'profile_image' => $profileImagePath,
        ]);
    
        Auth::login( $user);
    
        return redirect()->route('home');  // Rediriger vers la page d'accueil après la connexion
    }
    
// Route pour déconnexion
public function logout()
{
    Auth::logout(); // Déconnecter l'utilisateur
    return redirect()->route('home'); // Rediriger vers la page d'accueil
}

}
