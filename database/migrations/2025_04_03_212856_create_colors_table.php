<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nom unique de la couleur
            $table->string('hex_code', 7)->nullable(); // Code hexa sur 7 caractères (avec #)
            $table->timestamps();
        });

        // Insertion des couleurs de base
        DB::table('colors')->insert([
            ['name' => 'Rouge', 'hex_code' => '#FF0000', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vert', 'hex_code' => '#00FF00', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bleu', 'hex_code' => '#0000FF', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Noir', 'hex_code' => '#000000', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Blanc', 'hex_code' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jaune', 'hex_code' => '#FFFF00', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Violet', 'hex_code' => '#800080', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Orange', 'hex_code' => '#FFA500', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rose', 'hex_code' => '#FFC0CB', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gris', 'hex_code' => '#808080', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colors');
    }
};