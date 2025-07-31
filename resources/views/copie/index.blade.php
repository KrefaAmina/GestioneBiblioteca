@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-primary">
            📚 Copie disponibili per: <span class="fw-bold">{{ $libro->titolo }}</span>
        </h2>

        @if ($copie->isEmpty())
            <div class="alert alert-warning shadow rounded p-3">❌ Nessuna copia disponibile.</div>
        @else
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Codice a Barre</th>
                                <th>Stato</th>
                                <th>Disponibilità</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($copie as $copia)
                                <tr>
                                    <td>
                                        <img src="https://barcode.tec-it.com/barcode.ashx?data={{ $copia->codice_barre }}&code=Code128"
                                            alt="Barcode" class="img-fluid rounded shadow-sm" width="150">
                                    </td>

                                    <td>
                                        @php
                                            $stato = strtolower($copia->stato->value ?? $copia->stato);
                                            $color = match ($stato) {
                                                'ottimo' => 'success',
                                                'buono' => 'warning',
                                                'discreto' => 'secondary',
                                                default => 'light',
                                            };
                                        @endphp
                                        <span
                                            class="badge bg-{{ $color }} px-3 py-2 rounded-pill shadow-sm text-capitalize">
                                            {{ $stato }}
                                        </span>
                                    </td>

                                    <td>
                                        @php
                                            $disponibilita = strtolower(
                                                $copia->disponibilita->value ?? $copia->disponibilita,
                                            );
                                            $colorDisponibilita =
                                                $disponibilita === 'disponibile' ? 'success' : 'danger';
                                        @endphp
                                        <span
                                            class="badge bg-{{ $colorDisponibilita }} px-3 py-2 rounded-pill shadow-sm text-capitalize">
                                            {{ $disponibilita }}
                                        </span>
                                    </td>

                                    <td>
                                        <a href="{{ route('prenotazioni.create', ['copia_id' => $copia->id]) }}"
                                            class="btn btn-sm btn-success
                                                @if ($disponibilita !== 'disponibile') disabled @endif"
                                            @if ($disponibilita !== 'disponibile') aria-disabled="true" tabindex="-1" @endif>
                                            📅 Prenotare
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $copie->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('libri.index') }}" class="btn btn-outline-primary rounded-pill px-4 shadow-sm">
                ← Torna alla lista libri
            </a>
        </div>
    </div>
@endsection
