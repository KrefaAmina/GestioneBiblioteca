@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>📄 Dettagli della Copia</h2>

        <div class="card mt-3">
            <div class="card-body">
                <p><strong>📚 Libro:</strong> {{ $copia->libro->titolo }}</p>
                <p><strong>📄 Codice a Barre:</strong> {{ $copia->codice_barre }}</p>

                <p><strong>📖 Stato:</strong> {{ ucfirst($copia->stato->value) }}</p>

                <p><strong>📝 Note:</strong> {{ $copia->note ?? 'Nessuna' }}</p>

                <div class="mt-4">
                    <a href="{{ route('copie.index', $copia->libro_id) }}" class="btn btn-secondary">← Torna alle
                        Copie</a>
                </div>
            </div>
        </div>
    </div>
@endsection
