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
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('titolo');
            $table->string('isbn')->unique();
            $table->text('descrizione')->nullable();
            $table->string('categoria')->nullable();
            $table->string('autore')->nullable();
            $table->integer('annoPub');
            $table->string('editor')->nullable();
            $table->string('copertina')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};