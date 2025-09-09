<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la couleur
            $table->string('name', 50)->unique(); // Nom de la couleur (ex: 'Rouge', 'Bleu')
            $table->string('hex_code', 7); // Code hexadécimal de la couleur (ex: '#FF0000')
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colors');
    }
};
