@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4 text-gradient text-primary">📅 Gestione Prenotazioni</h1>

        <div class="card shadow-lg p-4">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        @php
                            // Funzione per generare i link di ordinamento
                            function sort_link($field, $label, $sortField, $sortDirection)
                            {
                                $direction = $sortField === $field && $sortDirection === 'asc' ? 'desc' : 'asc';
                                $icon = '';
                                if ($sortField === $field) {
                                    $icon =
                                        $sortDirection === 'asc'
                                            ? '<i class="fas fa-arrow-up ms-2 text-primary"></i>'
                                            : '<i class="fas fa-arrow-down ms-2 text-primary"></i>';
                                }
                                $url = route('prenotazioni.index_admin', ['sort' => $field, 'direction' => $direction]);
                                return '<a href="' .
                                    $url .
                                    '" class="text-decoration-none text-dark fw-bold">' .
                                    $label .
                                    $icon .
                                    '</a>';
                            }
                        @endphp

                        <th>{!! sort_link('user_id', 'Utente', $sortField, $sortDirection) !!}</th>
                        <th>{!! sort_link('posizione', 'Posizione', $sortField, $sortDirection) !!}</th>
                        <th>{!! sort_link('dateinizio', 'Data Inizio', $sortField, $sortDirection) !!}</th>
                        <th>{!! sort_link('datefino', 'Data Fine', $sortField, $sortDirection) !!}</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prenotazioni as $prenotazione)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 fw-semibold">{{ $prenotazione->user->name }}</p>
                                        <small class="text-muted">{{ $prenotazione->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $prenotazione->posizione }}</td>
                            <td>{{ \Carbon\Carbon::parse($prenotazione->dateinizio)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($prenotazione->datefino)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('prenotazioni.show', $prenotazione) }}" class="btn btn-sm btn-info me-2">
                                    <i class="fas fa-eye"></i> Visualizza
                                </a>
                                {{-- Altre azioni tipo modifica o cancella --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Nessuna prenotazione trovata.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-4">
                {{ $prenotazioni->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- FontAwesome per le icone freccia (se non già incluso) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endsection
