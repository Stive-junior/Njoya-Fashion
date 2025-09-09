<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('panier_items', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('panier_id'); 
            $table->unsignedBigInteger('article_id'); 
            $table->integer('quantity')->check('quantity > 0'); 
            $table->json('variants')->nullable()->after('price'); 
            $table->text('custom_message')->nullable()->after('variants');
            $table->json('variant_quantities')->nullable()->after('variants');

            $table->timestamp('added_at')->default(DB::raw('CURRENT_TIMESTAMP')); // Date d'ajout
            $table->timestamps();

            $table->foreign('panier_id')->references('id')->on('paniers');
            $table->foreign('article_id')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panier_items');
    }
};
