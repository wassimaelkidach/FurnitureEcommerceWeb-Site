<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
        return view('admin.products.create', compact('categories'));
    }

    // Enregistrer un nouveau produit
    public function store(Request $request)
{
    // Validation des données
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:1', // Validation pour la quantité
        'category_id' => 'required|exists:categories,id', // Validation pour la catégorie
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'images' => 'nullable|array',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Gestion de l'image principale
    $imagePath = $request->file('image')->store('products', 'public');

    // Création du produit avec la quantité et catégorie correctement ordonnés
    $product = Product::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'quantity' => $request->quantity, // Ajouter la quantité
        'category_id' => $request->category_id, // Ajouter la catégorie
        'image' => $imagePath, // Ajouter l'image principale
    ]);

    // Gestion des autres images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('product_images', 'public');  // Assure-toi de récupérer le chemin
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $imagePath,  // Insérer le chemin dans la colonne image_path
            ]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Produit ajouté avec succès.');
}


    // Afficher le formulaire de modification d'un produit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Charger les catégories pour le formulaire
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Mettre à jour un produit
    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer|min:1', // Validation pour la quantité
        ]);

        
        $product = Product::findOrFail($id);
        
        // Mise à jour de l'image principale
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            // Stocker la nouvelle image
            $product->image = $request->file('image')->store('products', 'public');
        }
    
        // Mise à jour des données de base

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity, // Ajouter ou mettre à jour la quantité
        ]);
    
        // Gestion des images supprimées
        if ($request->deleted_images) {
            $deletedImages = json_decode($request->deleted_images);
            foreach ($deletedImages as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image) {
                    Storage::delete('public/' . $image->image_path);
                    $image->delete();
                }
            }
        }
    
        // Ajout des nouvelles images
        if ($request->hasFile('images')) {
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