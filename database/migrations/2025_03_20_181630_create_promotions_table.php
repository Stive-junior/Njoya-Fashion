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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la promotion
            $table->string('name', 100); // Nom de la promotion
            $table->enum('discount_type', ['percentage', 'fixed']); // Type de réduction
            $table->decimal('discount_value', 10, 2); // Valeur de la réduction
            $table->enum('applies_to', ['all', 'category', 'product'])->default('all'); // Application de la promotion
            $table->foreignId('target_id')->nullable(); // ID de la cible (catégorie ou produit)
            $table->dateTime('start_date'); // Date et heure de début de la promotion
            $table->dateTime('end_date'); // Date et heure de fin de la promotion
            $table->timestamps(); // Date de création et de mise à jour
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
