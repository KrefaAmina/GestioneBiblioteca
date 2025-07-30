@extends('layouts.app')

@section('content')
    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
            </div>
        @endif

        <h2 class="mb-4">📚 Le mie prenotazioni</h2>

        @if ($prenotazioni->count())
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Titolo Libro</th>
                        <th>Codice a barre</th>
                        <th>Data Inizio</th>
                        <th>Data Fine</th>
                        <th>Stato</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prenotazioni as $prenotazione)
                        <tr>
                            <td>{{ $prenotazione->copia->libro->titolo ?? '-' }}</td>
                            <td>{{ $prenotazione->copia->codice_barre ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($prenotazione->dateinizio)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($prenotazione->datefino)->format('d/m/Y') }}</td>

                            <td>
                                {{-- Adapte selon ton champ stato o altro --}}
                                {{ ucfirst($prenotazione->stato ?? 'N/A') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $prenotazioni->links('pagination::bootstrap-5') }}
            </div>
        @else
            <p class="text-muted">Non hai ancora effettuato prenotazioni.</p>
        @endif
    </div>
@endsection
