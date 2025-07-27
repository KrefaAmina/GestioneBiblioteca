@extends('layouts.app') {{-- ou layouts.master si tu utilises Soft UI Dashboard --}}

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4>➕ Aggiungi una nuova categoria</h4>
                    </div>
                    <div class="card-body">
                        {{-- Affiche les erreurs de validation --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Formulaire --}}
                        <form action="{{ route('categorie.storeCategoria') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome della categoria</label>
                                <input type="text" class="form-control" id="nome" name="nome"
                                    value="{{ old('nome') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="descrizione" class="form-label">Descrizione (opzionale)</label>
                                <textarea class="form-control" id="descrizione" name="descrizione" rows="3">{{ old('descrizione') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-success">💾 Salva</button>
                            <a href="{{ route('categorie') }}" class="btn btn-secondary">↩️ Indietro</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
