<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Copia;
use App\Models\Libro;
use App\Enums\Disponibilita;

class CopiaController extends Controller
{
    /**
     * Metodo AJAX per restituire le copie disponibili per un libro
     * nel periodo selezionato, escludendo le copie già prenotate.
     * Usato nella modale con fetch() JS.
     */
   public function disponibiliAjax(Request $request)
{
    // Validazione con nomi aggiornati
    $request->validate([
        'libro_id' => 'required|exists:libri,id',
        'dateinizio' => 'required|date',
        'datefino' => 'required|date|after_or_equal:dateinizio',
    ]);

    $copie = Copia::where('libro_id', $request->libro_id)
        ->where('disponibilita', Disponibilita::Disponibile)
        ->whereNotIn('id', function ($query) use ($request) {
            $query->select('copia_id')
                ->from('prenotazioni')
                ->where(function ($q) use ($request) {
                    $q->whereBetween('dateinizio', [$request->dateinizio, $request->datefino])
                      ->orWhereBetween('datefino', [$request->dateinizio, $request->datefino])
                      ->orWhere(function ($q2) use ($request) {
                          $q2->where('dateinizio', '<=', $request->dateinizio)
                             ->where('datefino', '>=', $request->datefino);
                      });
                });
        })
        ->orderByRaw("FIELD(stato, 'ottimo', 'buono', 'discreto')")
        ->get(['id', 'codice_barre', 'stato']);

    return response()->json($copie);
}


    /**
     * Mostra la lista delle copie di un libro ordinate per stato.
     */
    public function index(Libro $libro)
    {
        $copie = Copia::where('libro_id', $libro->id)
            ->orderByRaw("FIELD(stato, 'ottimo', 'buono', 'discreto')")
            ->paginate(10);

        return view('copie.index', compact('libro', 'copie'));
    }

    /**
     * Versione "pagina intera" per mostrare le copie disponibili 
     * in un certo periodo. 
     */
 public function listaDisponibili(Request $request, Libro $libro)
{
    // Validazione dei parametri, usa dateinizio e datefino
    $request->validate([
        'dateinizio' => 'required|date',
        'datefino' => 'required|date|after_or_equal:dateinizio',
    ]);

    $copie = Copia::where('libro_id', $libro->id)
        ->where('disponibilita', 'disponibile')
        ->whereDoesntHave('prenotazioni', function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->whereBetween('dateinizio', [$request->dateinizio, $request->datefino])
                      ->orWhereBetween('datefino', [$request->dateinizio, $request->datefino])
                      ->orWhere(function ($q2) use ($request) {
                          $q2->where('dateinizio', '<=', $request->dateinizio)
                             ->where('datefino', '>=', $request->datefino);
                      });
            });
        })
        ->orderByRaw("FIELD(stato, 'ottimo', 'buono', 'discreto')")
        ->get();

    // Restituisce la vista con le copie disponibili e i parametri per mostrare le date nel form
    return view('copie.disponibili', [
        'copie' => $copie,
        'dateinizio' => $request->dateinizio,
        'datefino' => $request->datefino,
        'libro' => $libro
    ]);
}


    /**
     * Mostra il form per creare una nuova copia per un libro specifico.
     */
    public function create($libroId)
    {
        $libro = Libro::findOrFail($libroId);
        return view('copie.create', compact('libro'));
    }

    /**
     * Salva una nuova copia nel database associata a un libro.
     */
    public function store(Request $request, Libro $libro)
    {
        $validated = $request->validate([
            'stato' => 'required|in:ottimo,buono,discreto',
            'note' => 'nullable|string',
        ]);

        $validated['codice_barre'] = uniqid(); // Generazione codice a barre unico
        $validated['disponibilita'] = 'disponibile'; // Stato predefinito

        $libro->copie()->create($validated);

        return redirect()
            ->route('copie.index', $libro->id)
            ->with('success', '📦 Copia creata con successo.');
    }

    /**
     * Mostra i dettagli di una copia specifica.
     */
    public function show($id)
    {
        $copia = Copia::with('libro')->findOrFail($id);

        return view('copie.show', compact('copia'));
    }

    /**
     * Mostra il form di modifica per una copia (non ancora implementato).
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Aggiorna una copia esistente (non ancora implementato).
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Elimina una copia dal sistema (non ancora implementato).
     */
    public function destroy(string $id)
    {
        //
    }
}