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
            $table->date('dateinizio'); // data inizio prenotazione
            $table->date('datefino');   // data fine prenotazione
            $table->string('positione'); // indirizzo o posizione utente
            // clé étrangère (optionnelle)
            $table->foreign('id_ententi')->references('id')->on('users')->onDelete('cascade');
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