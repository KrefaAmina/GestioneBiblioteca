<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Libro;
use Illuminate\Http\Request;
use App\Enums\Disponibilita;

class LibroController extends Controller
{
     /**
     * Mostra la lista dei libri con possibilità di ricerca e filtri.
     */
    public function index(Request $request)
{
    // Recupero tutte le categorie per la select
    $categorie = Categoria::all();

    // Query base con relazione categorie e copie
    $query = Libro::with(['categorie', 'copie']);

    // Ricerca testuale (titolo, autore, isbn, descrizione)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('titolo', 'like', "%{$search}%")
              ->orWhere('autore', 'like', "%{$search}%")
              ->orWhere('isbn', 'like', "%{$search}%")
              ->orWhere('descrizione', 'like', "%{$search}%");
        });
    }

    // Filtro categoria
    if ($request->filled('categoria')) {
        $query->whereHas('categorie', function ($q) use ($request) {
            $q->where('categorie.id', $request->categoria);
        });
    }

   // Filtro disponibilità (dalla tabella copie)
if ($request->filled('disponibilita')) {
    $disponibilita = Disponibilita::tryFrom($request->disponibilita);
    if ($disponibilita) {
        $query->whereHas('copie', function ($q) use ($disponibilita) {
            $q->where('disponibilita', $disponibilita->value);
        });
    }
}

    // Filtro anno pubblicazione
    if ($request->filled('anno')) {
        $query->where('annoPub', $request->anno);
    }

    // Paginazione con 10 risultati
    $libri = $query->paginate(10)->withQueryString();

    return view('libri.list', compact('libri', 'categorie'));
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
   public function show(Request $request, Libro $libro)
{
    // Se ci sono i parametri dateinizio e datefino nella query, redirige alla lista copie disponibili
    if ($request->has(['dateinizio', 'datefino'])) {
        return redirect()->route('copie.listaDisponibili', [
            'libro' => $libro->id,
            'dateinizio' => $request->dateinizio,
            'datefino' => $request->datefino,
        ]);
    }

    // Altrimenti mostra la pagina normale del libro
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