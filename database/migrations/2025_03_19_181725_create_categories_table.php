<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
        $table->text('description')->nullable();
        $table->boolean('status')->default(1);
        $table->integer('order')->default(0);
        $table->softDeletes();
        $table->timestamp('published_at')->nullable();
        $table->timestamp('archived_at')->nullable();
        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
