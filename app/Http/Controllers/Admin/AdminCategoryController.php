<?php

namespace App\Http\Controllers\Admin;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
        // Afficher la page de création d'une catégorie
        public function create()
        {
            return view('admin.categories.create');
        }
    
        // Enregistrer la nouvelle catégorie
        public function store(Request $request)
        {
            // Valider les données
            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            // Gérer l'image si elle est présente
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('categories', 'public');
            }
    
            // Créer la nouvelle catégorie
            Category::create([
                'name' => $request->name,
                'image' => $imagePath,
            ]);
    
            return redirect()->route('admin.categories.index')->with('success', 'Catégorie ajoutée avec succès.');
        }
    
        // Afficher toutes les catégories (si tu veux une page d'index pour admin)
        public function index()
        {
            $categories = Category::all();
            return view('admin.categories.index', compact('categories'));
        }
        public function edit($id)
{
    $category = Category::findOrFail($id);
    return view('admin.categories.edit', compact('category'));
}

        public function update(Request $request, $id)
{
    $category = Category::findOrFail($id);

    // Validation des données
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Mettre à jour les données de la catégorie
    $category->name = $request->name;

    if ($request->hasFile('image')) {
        // Supprimer l'ancienne image
        if ($category->image) {
            Storage::delete('public/' . $category->image);
        }
        // Ajouter la nouvelle image
        $category->image = $request->file('image')->store('categories', 'public');
    }

    $category->save();

    return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès.');
}
public function destroy($id)
{
    $category = Category::findOrFail($id);
    
    // Supprimer l'image associée à la catégorie
    if ($category->image) {
        Storage::delete('public/' . $category->image);
    }

    $category->delete();

    return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès.');
}

}