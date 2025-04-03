<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // L'utilisateur qui ajoute aux favoris
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Le produit ajouté en favori
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('favorites');
    }
};