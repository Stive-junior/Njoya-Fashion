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
        Schema::create('adresses', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'adresse
            $table->unsignedBigInteger('user_id'); // Utilisateur associé (référence à la table users)
            $table->string('street', 255); // Rue
            $table->string('city', 100); // Ville
            $table->string('country', 100); // Pays
            $table->timestamps(); // Date de création et de mise à jour

            $table->foreign('user_id')->references('id')->on('users'); // Clé étrangère vers la table users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adresses');
    }
};
