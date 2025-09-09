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
        Schema::create('paniers', function (Blueprint $table) {
            $table->id(); // Identifiant unique du panier
            $table->unsignedBigInteger('user_id'); // Utilisateur associé (référence à la table users)
            $table->string('session_id')->nullable(); // ID de session pour les utilisateurs non connectés
            $table->dateTime('expires_at'); // Date d'expiration du panier
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users'); // Clé étrangère vers la table users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paniers');
    }
};
