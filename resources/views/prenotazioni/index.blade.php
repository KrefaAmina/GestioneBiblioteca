@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6 class="text-primary">📋 Lista Prenotazioni</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-4">Utente
                                </th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Libro</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">codice Barre
                                </th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Periodo</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Posizione
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($prenotazioni as $prenotazione)
                                <tr>
                                    <td class="ps-4">{{ $prenotazione->user->name ?? 'N/A' }}</td>
                                    <td>{{ $prenotazione->copia->libro->titolo ?? 'N/A' }}</td>
                                    <td>
                                        @if ($prenotazione->copia?->codice_barre)
                                            <!-- ✅ Immagine del codice a barre generata dinamicamente -->
                                            <img src="https://barcode.tec-it.com/barcode.ashx?data={{ $prenotazione->copia->codice_barre }}&code=Code128&dpi=96"
                                                alt="code-barre" style="height:40px;" class="mb-1">
                                        @else
                                            —
                                        @endif
                                    </td>

                                    <td>
                                        @if ($prenotazione->dateinizio && $prenotazione->datefino)
                                            📅 {{ \Carbon\Carbon::parse($prenotazione->dateinizio)->format('d/m/Y') }}
                                            →
                                            {{ \Carbon\Carbon::parse($prenotazione->datefino)->format('d/m/Y') }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>{{ $prenotazione->copia->posizione ?? 'Non assegnata' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-secondary">Nessuna prenotazione trovata.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $prenotazioni->links() }} <!-- Pagination -->
        </div>
    </div>
@endsection
