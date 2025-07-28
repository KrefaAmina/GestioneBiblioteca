<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $libri = Libro::with('categorie')->paginate(10);

        return view('libri.list', compact('libri'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titolo' => 'required|string',
            'isbn' => 'nullable|string',
            'descrizione' => 'nullable|string',
            'autore' => 'nullable|string',
            'annoPub' => 'nullable|integer',
            'editor' => 'nullable|string',
            'copertina' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categorie' => 'nullable|array',
            'categorie.*' => 'exists:categorie,id'
        ]);

        if ($request->hasFile('copertina')) {
            $path = $request->file('copertina')->store('copertine', 'public');
            $validated['copertina'] = $path;
        }

        $libro = Libro::create($validated);

        if ($request->has('categorie')) {
            $libro->categorie()->attach($request->categorie);
        }

        return redirect()->route('libri.index')->with('success', 'Libro aggiunto!');
    }

    public function create()
    {
        $categorie = Categoria::all();
        return view('libri.create', compact('categorie'));
    }




    /**
     * Display the specified resource.
     */
    public function show(Libro $libro)
{
    return view('libri.show', compact('libro'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Libro $libro)
    {
        $categorie = Categoria::all(); //per select categoria
        return view('libri.edit', compact('libro', 'categorie'));
    }
    
    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Libro $libro)
    {
        $validated = $request->validate([
            'titolo' => 'required|string',
            'isbn' => 'nullable|string',
            'descrizione' => 'nullable|string',
            'autore' => 'nullable|string',
            'annoPub' => 'nullable|integer',
            'editor' => 'nullable|string',
            'copertina' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categorie' => 'nullable|array',
        ]);

        if ($request->hasFile('copertina')) {
            $path = $request->file('copertina')->store('copertine', 'public');
            $validated['copertina'] = $path;
        }

        $libro->update($validated);
        $libro->categorie()->sync($request->categorie);

        return redirect()->route('libri.index')->with('success', 'Libro aggiornato con successo!');
    }



    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Libro $libro)
{
    // Elimina l'immagine di copertina se presente
    if ($libro->copertina) {
        \Storage::disk('public')->delete($libro->copertina);
    }

    // Scollega le categorie associate (many-to-many)
    $libro->categorie()->detach();

    // Elimina il libro dal database
    $libro->delete();

    // Reindirizza alla lista con messaggio di successo
    return redirect()->route('libri.index')->with('success', 'Libro eliminato con successo!');
}

}