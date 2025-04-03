<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Color;

class AdminProductController extends Controller
{
    // Afficher la liste des produits
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    // Afficher le formulaire de création d'un produit
    public function create()
    {

    $categories = Category::all(); // Charger les catégories pour le formulaire
    $colors = Color::all(); // Charger les couleurs disponibles
    return view('admin.products.create', compact('categories', 'colors'));
}

    
    // Enregistrer un nouveau produit
    public function store(Request $request)
{
    // Validation des données
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:1',
        'category_id' => 'required|exists:categories,id',
        'colors' => 'required|array', // Validation des couleurs
        'colors.*' => 'exists:colors,id', // Vérification que les couleurs existent dans la table `colors`
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'images' => 'nullable|array',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Gestion de l'image principale
    $imagePath = $request->file('image')->store('products', 'public');

    // Création du produit
    $product = Product::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'category_id' => $request->category_id,
        'image' => $imagePath,
    ]);

    // Attacher les couleurs au produit
    $product->colors()->attach($request->colors); // Attacher les couleurs sélectionnées

    // Gestion des autres images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('product_images', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $imagePath,
            ]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Produit ajouté avec succès.');
}


    // Afficher le formulaire de modification d'un produit
  
        public function edit($id)
        {
            $product = Product::findOrFail($id);
            return view('admin.products.edit', compact('product'));
        }
    

    // Mettre à jour un produit
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'colors' => 'required|array', // Validation des couleurs
            'colors.*' => 'exists:colors,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $product = Product::findOrFail($id);
    
        // Mise à jour de l'image principale
        if ($request->hasFile('main_image')) {
            // Supprimer l'ancienne image
            if ($product->main_image && Storage::exists('public/' . $product->main_image)) {
                Storage::delete('public/' . $product->main_image);
            }
            // Ajouter la nouvelle image
            $product->main_image = $request->file('main_image')->store('products', 'public');
        }
    
        // Mise à jour du produit
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
        ]);
    
        // Mise à jour des couleurs
        $product->colors()->sync($request->colors); // Synchroniser les couleurs (ajoute et supprime les couleurs)
    
        // Mise à jour des images supplémentaires
        if ($request->hasFile('images')) {
            $oldImages = ProductImage::where('product_id', $product->id)->get();
            foreach ($oldImages as $oldImage) {
                if (Storage::exists('public/' . $oldImage->image)) {
                    Storage::delete('public/' . $oldImage->image);
                }
                $oldImage->delete();
            }
    
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                ]);
            }
        }
    
        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour avec succès.');
    }
    
    // Supprimer un produit
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Supprimer les images associées au produit
        foreach ($product->images as $image) {
            Storage::delete('public/' . $image->image);
            $image->delete();
        }

        // Supprimer l'image principale
        Storage::delete('public/' . $product->main_image);

        // Supprimer le produit
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé avec succès.');
    }
}
