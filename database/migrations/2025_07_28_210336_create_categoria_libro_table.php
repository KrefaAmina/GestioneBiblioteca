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
        Schema::create('categoria_libro', function (Blueprint $table) {
           $table->id();
            $table->foreignId('categoria_id')->constrained('categorie')->onDelete('cascade');
            $table->foreignId('libro_id')->constrained('libri')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoria_libro');
    }
};