<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'category_id', 'quantity','image'];

    // Relation avec les images
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Relation avec la catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function reviews()
    {
    return $this->hasMany(Review::class);
    }

public function hasSufficientStock($requestedQuantity) {
    return $this->stock >= $requestedQuantity;
}



}