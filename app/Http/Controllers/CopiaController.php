<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Copia;
use App\Models\Libro;

class CopiaController extends Controller
{
    /**
     * Display a listing of the copia.
     */
    public function index(Libro $libro)
    {
        $copie = $libro->copie()->paginate(10);
        return view('copie.index', compact('copie', 'libro'));
    }


    /**
     * Mostra il form per creare una nuova copia di un libro specifico
     */

    public function create($libroId)
    {
        $libro = Libro::findOrFail($libroId);
        return view('copie.create', compact('libro'));
    }


    /**
     * Salva la nuova copia nel database collegata al libro
     */

    public function store(Request $request, Libro $libro)
    {
        // Validazione dei dati
        $validated = $request->validate([
            'stato' => 'required|in:ottimo,buono,discreto',

            'note' => 'nullable|string',
        ]);

        // Generazione automatica di un codice a barre univoco
        $validated['codice_barre'] = uniqid(); // oppure usare Str::uuid() per una versione più lunga

        $validated['disponibilita'] = 'disponibile'; // valore predefinito

        // Creazione della copia e associazione al libro
        $libro->copie()->create($validated);

        // Reindirizzamento alla lista delle copie del libro
        return redirect()
            ->route('copie.index', $libro->id)
            ->with('success', '📦 Copia creata con successo.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
