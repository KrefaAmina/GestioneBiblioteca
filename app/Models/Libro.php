<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{

    protected $table = 'libri';

    protected $fillable = [
        'titolo',
        'isbn',
        'descrizione',
        'categoria',
        'autore',
        'annoPub',
        'editor',
        'copertina'
    ];

    public function categorie()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_libro', 'libro_id', 'categoria_id');
    }

    public function copie()
{
    return $this->hasMany(Copia::class);
}
public function copieDisponibili()
{
    return $this->hasMany(Copia::class)->where('disponibilita', 'disponibile');
}

}