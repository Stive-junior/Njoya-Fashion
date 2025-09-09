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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'élément de commande
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade')->onUpdate('cascade') ; // Commande associée (référence à la table orders)
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade')->onUpdate('cascade') ; // Article commandé (référence à la table articles)
            $table->integer('quantity'); // Quantité commandée
            $table->decimal('unit_price', 10, 2); // Prix unitaire au moment de la commande
            $table->timestamps(); // Date de création et de mise à jour
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
