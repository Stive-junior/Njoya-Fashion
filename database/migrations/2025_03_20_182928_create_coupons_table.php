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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id(); // Identifiant unique du coupon
            $table->string('code', 20)->unique()->notNullable(); // Code du coupon
            $table->enum('discount_type', ['percentage', 'fixed'])->notNullable(); // Type de réduction (pourcentage ou fixe)
            $table->decimal('discount_value', 10, 2)->notNullable(); // Valeur de la réduction
            $table->integer('max_uses')->notNullable(); // Nombre maximal d'utilisations
            $table->integer('used_count')->default(0); // Nombre de fois utilisé
            $table->date('valid_from')->notNullable(); // Date de début de validité
            $table->date('valid_until')->notNullable(); // Date de fin de validité
            $table->decimal('min_order_amount', 10, 2)->default(0.00); // Montant minimum de commande pour appliquer le coupon
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
