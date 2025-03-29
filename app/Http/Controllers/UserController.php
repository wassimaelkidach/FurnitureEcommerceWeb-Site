<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // Afficher le dashboard de l'utilisateur
    public function dashboard()
    {
        return view('user.dashboard');
    }
}
