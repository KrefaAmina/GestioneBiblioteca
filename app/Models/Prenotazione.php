<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prenotazione extends Model
{
    protected $table = 'prenotazioni';

    protected $fillable = [
        'dateinizio',
        'datefino',
        'posizione',
        'user_id',
        'copia_id',
    ];

    protected $casts = [
        'dateinizio' => 'datetime',
        'datefino'   => 'datetime',
    ];
    
    /**
     * Relazione con l'utente che ha effettuato la prenotazione.
     * Una prenotazione appartiene a un utente.
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relazione con la copia del libro prenotata.
     * Una prenotazione riguarda una sola copia.
     */

    public function copia()
    {
         return $this->belongsTo(Copia::class, 'copia_id');
    }
    
}