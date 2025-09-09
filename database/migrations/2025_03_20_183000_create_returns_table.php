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
        Schema::create('returns', function (Blueprint $table) {
            $table->id(); // Identifiant unique du retour
            $table->unsignedBigInteger('order_item_id'); // Élément de commande retourné (référence à la table order_items)
            $table->text('reason'); // Raison du retour
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Statut du retour
            $table->decimal('refund_amount', 10, 2); // Montant remboursé
            $table->timestamps();

            $table->foreign('order_item_id')->references('id')->on('order_items'); // Clé étrangère
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
