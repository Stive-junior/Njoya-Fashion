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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la méthode de paiement
            $table->string('name', 50); // Nom de la méthode (ex: 'Carte de crédit', 'PayPal')
            $table->boolean('is_active')->default(true); // Indique si la méthode est active ou non
            $table->string('numero', 100);
            $table->string('logo', 255)->nullable(); 
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payement_methods');
    }
};
