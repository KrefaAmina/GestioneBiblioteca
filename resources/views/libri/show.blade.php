@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">{{ $libro->titolo }}</h2>

        <div class="row">
            <div class="col-md-4">
                @if ($libro->copertina)
                    <img src="{{ asset('storage/' . $libro->copertina) }}" class="img-fluid rounded shadow"
                        alt="{{ $libro->titolo }}">
                @else
                    <img src="https://via.placeholder.com/300x400?text=Nessuna+Copertina" class="img-fluid rounded shadow"
                        alt="Placeholder">
                @endif
            </div>

            <div class="col-md-8">
                <p><strong>Autore:</strong> {{ $libro->autore }}</p>
                <p><strong>ISBN:</strong> {{ $libro->isbn }}</p>
                <p><strong>Descrizione:</strong>{{ $libro->descrizione }}</p>
                <p><strong>Anno:</strong>{{ $libro->annoPub }}</p>
                <p><strong>Editore:</strong>{{ $libro->editor }}</p>
                <p><strong>Categorie:</strong>
                    @foreach ($libro->categorie as $categoria)
                        <a href="{{ route('categorie.libri', $categoria->id) }}" class="badge bg-primary text-white me-1">
                            {{ $categoria->nome }}
                        </a>
                    @endforeach
                </p>
                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('copie.index', $libro) }}" class="btn btn-info">
                        📄 Vedi Copie
                    </a>
                    <a href="{{ route('libri.index') }}" class="btn btn-secondary"> Torna alla lista</a>
                </div>

            </div>
        </div>
    </div>
@endsection
