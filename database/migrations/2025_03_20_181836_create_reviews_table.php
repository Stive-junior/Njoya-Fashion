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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'avis
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Utilisateur ayant posté l'avis (référence à la table users)
            $table->foreignId('article_id')->constrained()->onDelete('cascade'); // Article concerné (référence à la table articles)
            $table->tinyInteger('rating')->check('rating BETWEEN 1 AND 5'); // Note de 1 à 5
            $table->text('comment')->nullable(); // Commentaire de l'utilisateur
            $table->timestamps(); // Date de création et de mise à jour
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
