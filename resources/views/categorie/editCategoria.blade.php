@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4>✏️ Modifica Categoria</h4>
                    </div>
                    <div class="card-body">
                        {{-- Affiche les erreurs --}}
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
                        <form method="POST" action="{{ route('categorie.saveCategoria', $categoria->id) }}">
                            @csrf
                            @method('PUT')


                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome della categoria</label>
                                <input type="text" name="nome" id="nome" class="form-control"
                                    value="{{ old('nome', $categoria->nome) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="descrizione" class="form-label">Descrizione</label>
                                <textarea name="descrizione" id="descrizione" class="form-control" rows="3">{{ old('descrizione', $categoria->descrizione) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">💾 Salva modifiche</button>
                            <a href="{{ route('categorie') }}" class="btn btn-secondary">↩️ Indietro</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
