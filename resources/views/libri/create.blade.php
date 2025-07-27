@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>➕ Aggiungi un Nuovo Libro</h2>

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Attenzione!</strong> Ci sono dei problemi con i dati inseriti:<br>
                <ul>
                    @foreach ($errors->all() as $errore)
                        <li>{{ $errore }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire -->
        <form action="{{ route('libri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="titolo" class="form-label">Titolo</label>
                <input type="text" name="titolo" class="form-control" value="{{ old('titolo') }}" required>
            </div>

            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control" value="{{ old('isbn') }}">
            </div>

            <div class="mb-3">
                <label for="autore" class="form-label">Autore</label>
                <input type="text" name="autore" class="form-control" value="{{ old('autore') }}">
            </div>

            <div class="mb-3">
                <label for="annoPub" class="form-label">Anno di Pubblicazione</label>
                <input type="number" name="annoPub" class="form-control" value="{{ old('annoPub') }}">
            </div>

            <div class="mb-3">
                <label for="editor" class="form-label">Editore</label>
                <input type="text" name="editor" class="form-control" value="{{ old('editor') }}">
            </div>

            <div class="mb-3">
                <label for="descrizione" class="form-label">Descrizione</label>
                <textarea name="descrizione" class="form-control" rows="3">{{ old('descrizione') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="copertina" class="form-label">Copertina (immagine)</label>
                <input type="file" name="copertina" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="categorie" class="form-label">Categorie</label>
                <select name="categorie[]" class="form-select" multiple>
                    @foreach ($categorie as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">💾 Salva</button>
            <a href="{{ route('libri.index') }}" class="btn btn-secondary">↩️ Annulla</a>
        </form>
    </div>
@endsection
