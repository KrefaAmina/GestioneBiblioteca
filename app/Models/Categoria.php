<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Categoria extends Model
{
    protected $table = 'categorie';

    protected $fillable = ['nome', 'descrizione'];

    //aggiungere relazioni a Libro
    public function libri()
    {
        return $this->belongsToMany(Libro::class, 'categoria_libro', 'categoria_id', 'libro_id');
    }
}
