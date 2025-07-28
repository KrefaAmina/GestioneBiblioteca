@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
        </div>
    @endif

    <div class="container py-4">
        <h2 class="mb-4">📄 Copie del libro: <strong>{{ $libro->titolo }}</strong></h2>

        <a href="{{ route('libri.show', $libro) }}" class="btn btn-secondary mb-3"> Torna al libro</a>

        @if ($copie->count())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>📄 Codice a Barre</th>
                            <th>📖 Stato</th>
                            <th>✅ Disponibilità</th>
                            <th>📝 Note</th>
                            <th>⚙️ Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($copie as $copia)
                            <tr>
                                <td>{{ $copia->codice_barre }}</td>
                                <td>{{ ucfirst($copia->stato->value) }}</td>
                                <td>{{ ucfirst($copia->disponibilita->value) }}</td>
                                <td>{{ $copia->note }}</td>
                                <td>
                                    <a href="{{ route('copie.show', $copia) }}" class="btn btn-sm btn-info">👁️
                                        Visualizza</a>

                                    {{-- Bouton de réservation --}}
                                    <a href="{{ route('prenotazioni.create', ['copia_id' => $copia->id]) }}"
                                        class="btn btn-sm btn-success">
                                        📅 Prenota
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">
                    {{ $copie->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @else
            <p class="text-muted">📭 Nessuna copia disponibile per questo libro.</p>
        @endif
    </div>
@endsection
