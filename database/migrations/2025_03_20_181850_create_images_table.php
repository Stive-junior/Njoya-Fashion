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
        Schema::create('images', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'image
            $table->string('url', 255)->notNull(); // URL de l'image
            $table->unsignedBigInteger('article_id')->notNull(); // Article associé (référence à la table articles)
            $table->timestamps(); // Date de création et de mise à jour

            $table->foreign('article_id')->references('id')->on('articles'); // Clé étrangère vers la table articles
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
