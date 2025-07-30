<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Stato;
use App\Enums\Disponibilita;
use Illuminate\Support\Str;

class Copia extends Model
{
    protected $table = 'copie';

    protected $fillable = [
        //'codice_barre': viene generato automaticamente, quindi non va qui
        'stato',
        'disponibilita',
        'note',
        'libro_id',
    ];

    /**
     * Caster les champs enum
     */
    protected $casts = [
        'stato' => Stato::class,
        'disponibilita' => Disponibilita::class,
    ];

    /**
     * Relazione con il modello Libro (una copia appartiene a un libro)
     */

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }
    /**
     * Relazione con il modello prenotazione (una copia appartiene a many prenotazioni)
     */

     public function prenotazioni()
    {
        return $this->hasMany(Prenotazione::class, 'copia_id');
    }

    /**
     * Metodo boot() per registrare eventi sul modello.
     * Qui generiamo automaticamente un codice a barre univoco prima di salvare.
     */
    protected static function boot()
    {
        parent::boot();

        // Evento "creating": prima che una copia venga salvata nel database
        static::creating(function ($copia) {
            $copia->codice_barre = self::generaCodiceUnivoco();
        });
    }

    /**
     * Genera un codice a barre casuale e univoco.
     * Usiamo un ciclo do...while per garantire che non sia già presente nel database.
     */
    public static function generaCodiceUnivoco()
    {
        do {
            $code = strtoupper(Str::random(10)); // Esempio: "A1B2C3D4E5"
        } while (self::where('codice_barre', $code)->exists());

        return $code;
    }
}