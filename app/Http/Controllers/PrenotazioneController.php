<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Copia;
use App\Models\Prenotazione;

class PrenotazioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
  public function indexAdmin(Request $request)
{
    // Prendi i parametri di ordinamento dalla query (con valori di default)
    $sortField = $request->get('sort', 'dateinizio');
    $sortDirection = $request->get('direction', 'asc');

    // Lista dei campi consentiti per ordinare (per sicurezza)
    $allowedSortFields = ['dateinizio', 'datefino', 'posizione', 'user_id'];

    // Se il campo di ordinamento non è consentito, usa il default
    if (!in_array($sortField, $allowedSortFields)) {
        $sortField = 'dateinizio';
    }

    // Se la direzione non è asc o desc, usa asc
    if (!in_array($sortDirection, ['asc', 'desc'])) {
        $sortDirection = 'asc';
    }

    $prenotazioni = Prenotazione::with(['user', 'copia.libro'])
        ->orderBy($sortField, $sortDirection)
        ->paginate(15);

    return view('prenotazioni.index_admin', compact('prenotazioni', 'sortField', 'sortDirection'));
}
public function storeAndRedirect(Request $request)
{
    $request->validate([
        'copia_id' => 'required|exists:copie,id',
        'dateinizio' => 'required|date',
        'datefino' => 'required|date|after_or_equal:dateinizio',
    ]);

    Prenotazione::create([
        'user_id' => Auth::id(),
        'copia_id' => $request->copia_id,
        'date_inizio' => $request->dateinizio,
        'date_fine' => $request->datefino,
    ]);

    return redirect()->route('prenotazioni.user_list')
        ->with('success', 'Prenotazione effettuata con successo!');
}



    /**
     * Mostra il form per creare una nuova prenotazione.
     */
    public function create(Request $request)
    
    {
        // Se viene passato un id_copia (es. dalla lista copie)
        $copiaId = $request->query('copia_id');

        // Trova la copia o null
        $copia = $copiaId ? Copia::find($copiaId) : null;

        
        
        return view('prenotazioni.create', compact('copia'));
    }

    /**
     * Salva la nuova prenotazione nel database
     */
    public function store(Request $request)
{
    // Valida i dati inviati dal form
    $validated = $request->validate([
        'copia_id' => 'required|exists:copie,id',
        'dateinizio' => 'required|date',
        'datefino' => 'required|date|after_or_equal:dateinizio',
    ]);

    // Recupera la posizione dalla copia selezionata
    $copia = \App\Models\Copia::findOrFail($validated['copia_id']);
    $validated['posizione'] = $copia->posizione;

    try {
        // Crea la prenotazione per l'utente autenticato
        $prenotazione = auth()->user()->prenotazioni()->create($validated);

        // Reindirizza alla lista delle prenotazioni dell’utente con messaggio di successo
        return redirect()->route('prenotazioni.user_list')
            ->with('success', 'Prenotazione creata con successo!');
    } catch (\Exception $e) {
        // In caso di errore, torna indietro con messaggio di errore
        return back()->withErrors('Errore nella creazione della prenotazione. Riprova.'. $e->getMessage());
    }
}


public function userList()
{
    /** @var \App\Models\User $user */
    $prenotazioni = auth()->user()
        ->prenotazioni()
        ->with('copia.libro')   // Important pour afficher le titolo du libro sans requêtes supplémentaires
        ->orderBy('dateinizio', 'desc')
        ->paginate(10);

    return view('prenotazioni.user_list', compact('prenotazioni'));
}


    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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