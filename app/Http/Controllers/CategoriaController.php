<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Libro;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::paginate(10);
        return view('categorie.listCategorie', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categorie.createCategoria');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descrizione' => 'nullable|string',
        ]);

        Categoria::create($validated);
        return redirect()->route('categorie')->with('success', 'Categoria creata!');
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
    public function edit(Categoria $categoria)
    {
        return view('categorie.editCategoria', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descrizione' => 'nullable|string',
        ]);

        $categoria->update($validated);
        return redirect()->route('categorie')->with('success', 'Categoria aggiornata!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorie')->with('success', 'Categoria eliminata!');
    }

    public function showLibri(Categoria $categoria)
{
   
    $libri = $categoria->libri()->paginate(10);

    return view('categorie.libri', compact('categoria', 'libri'));
}

}