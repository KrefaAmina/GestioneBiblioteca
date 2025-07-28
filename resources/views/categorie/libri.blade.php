@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Libri nella categoria: <strong>{{ $categoria->nome }}</strong></h2>

    @if($libri->isEmpty())
        <p>Nessun libro trovato in questa categoria.</p>
    @else
        <div class="row">
            @foreach($libri as $libro)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($libro->copertina)
                            <img src="{{ asset('storage/' . $libro->copertina) }}" class="card-img-top" alt="{{ $libro->titolo }}">
                        @else
                            <img src="https://via.placeholder.com/150x220?text=No+Image" class="card-img-top" alt="Nessuna immagine">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $libro->titolo }}</h5>
                            <p class="card-text text-muted">Autore: {{ $libro->autore }}</p>
                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('libri.show', $libro->id) }}" class="btn btn-sm btn-outline-primary">Dettagli</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
