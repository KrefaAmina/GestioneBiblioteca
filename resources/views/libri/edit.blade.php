@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-primary text-white">
                        <h5 class="mb-0">✏️ Modifica Libro</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('libri.update', $libro) }}" method="POST" enctype="multipart/form-data">

                            @csrf
                            @method('PUT')

                            <!-- Titolo -->
                            <div class="mb-3">
                                <label for="titolo" class="form-label">Titolo</label>
                                <input type="text" name="titolo" class="form-control"
                                    value="{{ old('titolo', $libro->titolo) }}" required>
                            </div>

                            <!-- ISBN -->
                            <div class="mb-3">
                                <label for="isbn" class="form-label">ISBN</label>
                                <input type="text" name="isbn" class="form-control"
                                    value="{{ old('isbn', $libro->isbn) }}">
                            </div>

                            <!-- Descrizione -->
                            <div class="mb-3">
                                <label for="descrizione" class="form-label">Descrizione</label>
                                <textarea name="descrizione" class="form-control" rows="3">{{ old('descrizione', $libro->descrizione) }}</textarea>
                            </div>

                            <!-- Autore -->
                            <div class="mb-3">
                                <label for="autore" class="form-label">Autore</label>
                                <input type="text" name="autore" class="form-control"
                                    value="{{ old('autore', $libro->autore) }}">
                            </div>

                            <!-- Anno pubblicazione -->
                            <div class="mb-3">
                                <label for="annoPub" class="form-label">Anno di pubblicazione</label>
                                <input type="number" name="annoPub" class="form-control"
                                    value="{{ old('annoPub', $libro->annoPub) }}">
                            </div>

                            <!-- Editore -->
                            <div class="mb-3">
                                <label for="editor" class="form-label">Editore</label>
                                <input type="text" name="editor" class="form-control"
                                    value="{{ old('editor', $libro->editor) }}">
                            </div>

                            <!-- Copertina attuale -->
                            <div class="mb-3">
                                <label class="form-label">Copertina attuale:</label><br>
                                @if ($libro->copertina)
                                    <img src="{{ asset('storage/' . $libro->copertina) }}"
                                        class="img-fluid rounded shadow-sm" style="height: 100px;">
                                @else
                                    <p class="text-muted">Nessuna copertina</p>
                                @endif
                            </div>

                            <!-- Nuova Copertina -->
                            <div class="mb-3">
                                <label for="copertina" class="form-label">Carica nuova copertina</label>
                                <input type="file" name="copertina" class="form-control">
                            </div>

                            <!-- Categorie -->
                            <div class="mb-3">
                                <label for="categorie" class="form-label">Categorie</label>
                                <select name="categorie[]" class="form-select" multiple>
                                    @foreach ($categorie as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $libro->categorie->contains($cat->id) ? 'selected' : '' }}>
                                            {{ $cat->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Bottoni -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-2">💾 Salva</button>
                                <a href="{{ route('libri.index') }}" class="btn btn-outline-secondary">Annulla</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
