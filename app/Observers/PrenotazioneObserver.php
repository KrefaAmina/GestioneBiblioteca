<?php

namespace App\Observers;

use App\Models\Prenotazione;

class PrenotazioneObserver
{
     /**
     * Gestisce l'evento "created" del modello Prenotazione.
     *
     * @param  \App\Models\Prenotazione  $prenotazione
     * @return void
     */
    public function created(Prenotazione $prenotazione)
    {
       // Recupera la copia associata alla prenotazione
        $copia = $prenotazione->copia;

        if ($copia) {
            // Aggiorna la disponibilità a 'prenotata'
            $copia->disponibilita = 'prenotata';
            $copia->save();
        }
    }
    /**
     * Handle the Prenotazione "updated" event.
     */
    public function updated(Prenotazione $prenotazione): void
    {
        //
    }

    /**
     * Handle the Prenotazione "deleted" event.
     */
    public function deleted(Prenotazione $prenotazione): void
    {
        //
    }

    /**
     * Handle the Prenotazione "restored" event.
     */
    public function restored(Prenotazione $prenotazione): void
    {
        //
    }

    /**
     * Handle the Prenotazione "force deleted" event.
     */
    public function forceDeleted(Prenotazione $prenotazione): void
    {
        //
    }
}