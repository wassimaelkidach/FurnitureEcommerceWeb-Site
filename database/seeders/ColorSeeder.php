<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    public function run()
    {
        $colors = [
            ['name' => 'Rouge', 'hex_code' => '#FF0000'],
            ['name' => 'Vert', 'hex_code' => '#00FF00'],
            ['name' => 'Bleu', 'hex_code' => '#0000FF'],
            ['name' => 'Noir', 'hex_code' => '#000000'],
            ['name' => 'Blanc', 'hex_code' => '#FFFFFF'],
            ['name' => 'Jaune', 'hex_code' => '#FFFF00'],
            ['name' => 'Violet', 'hex_code' => '#800080'],
            ['name' => 'Orange', 'hex_code' => '#FFA500'],
            ['name' => 'Rose', 'hex_code' => '#FFC0CB'],
            ['name' => 'Gris', 'hex_code' => '#808080'],
        ];

        DB::table('colors')->insert($colors);
    }
}