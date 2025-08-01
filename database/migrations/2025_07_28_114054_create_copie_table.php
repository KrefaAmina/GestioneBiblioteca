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
        Schema::create('copie', function (Blueprint $table) {
            $table->id();
            $table->string('codice_barre')->unique();
            $table->enum('stato', ['ottimo', 'buono', 'discreto']);
            $table->enum('disponibilita', ['disponibile', 'prenotata']);
            $table->string('note')->nullable();
            $table->foreignId('libro_id')->constrained('libri')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copie');
    }
};
