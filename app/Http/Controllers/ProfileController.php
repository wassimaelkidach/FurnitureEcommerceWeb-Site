<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    // Afficher le profil de l'utilisateur connecté
    public function show()
    {
        $user = Auth::user(); // Récupère l'utilisateur connecté
        return view('profil.show', ['user' => $user]); // Passe l'objet utilisateur à la vue
    }
    
    // Mettre à jour le profil de l'utilisateur
    public function update(Request $request)
    {
        $request->validate([
            'name'          => 'required|max:255',
            'birthday'      => 'nullable|date',
            'phone'         => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            // Tu peux ajouter d'autres règles de validation si nécessaire
        ]);

        $user = auth::user();

        // Mise à jour des informations de base
        $user->name     = $request->name;
        $user->birthday = $request->birthday;
        $user->phone    = $request->phone;

        // Si un nouveau fichier image est envoyé
        if ($request->hasFile('profile_image')) {
            // Supprime l'ancienne image si elle existe
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            // Stocke la nouvelle image et récupère son chemin
            $user->profile_image = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user->save();

        return redirect()->route('profil.show')->with('success', 'Profil mis à jour avec succès.');
    }
}
