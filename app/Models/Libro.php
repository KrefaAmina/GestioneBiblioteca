<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
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
    return $this->belongsToMany(Categoria::class);
}

}
