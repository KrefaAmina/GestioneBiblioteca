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
        Schema::create('prenotazioni', function (Blueprint $table) {
            $table->id();      

            // ID dell'utente che effettua la prenotazione ( 🔑 Relazione con l'utente)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // ID della copia prenotata (🔑 Relazione con la copia del libro)
            $table->foreignId('copia_id')->constrained('copie')->onDelete('cascade');

             // 📅 Date d'inizio e di fine prenotazione
            $table->date('dateinizio');
            $table->date('datefino');

            // 📍 Posizione dell copia
            $table->string('posizione')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prenotazioni');
    }
};