<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


    
    return new class extends Migration {
        public function up()
        {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('image')->nullable()->after('name'); // Ajout du champ image
            });
        }
    
        public function down()
        {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }
    };
    

