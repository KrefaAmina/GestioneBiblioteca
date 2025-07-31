@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">📅 Nuova Prenotazione</h2>

        <form action="{{ route('prenotazioni.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="copia_id" class="form-label">Copia</label>
                @if ($copia)
                    <input type="text" class="form-control" value="Codice a barre: {{ $copia->codice_barre }}" disabled>
                    <input type="hidden" name="copia_id" value="{{ $copia->id }}">
                @else
                    <select name="copia_id" id="copia_id" class="form-select @error('copia_id') is-invalid @enderror">
                        <option value="">Seleziona una copia</option>
                        @foreach (\App\Models\Copia::all() as $item)
                            <option value="{{ $item->id }}" {{ old('copia_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->codice_barre }} - {{ ucfirst($item->stato->value) }}
                            </option>
                        @endforeach
                    </select>
                    @error('copia_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                @endif
            </div>

            <div class="mb-3">
                <label for="dateinizio" class="form-label">Data Inizio</label>
                <input type="date" name="dateinizio" id="dateinizio"
                    class="form-control @error('dateinizio') is-invalid @enderror" value="{{ old('dateinizio') }}">
                @error('dateinizio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="datefino" class="form-label">Data Fine</label>
                <input type="date" name="datefino" id="datefino"
                    class="form-control @error('datefino') is-invalid @enderror" value="{{ old('datefino') }}">
                @error('datefino')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">📅 Prenota</button>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dateinizio = document.getElementById("dateinizio");
            const datefino = document.getElementById("datefino");

            if (dateinizio && datefino) {
                const today = new Date().toISOString().split("T")[0];

                //Non consentire date passate per entrambi i campi
                dateinizio.setAttribute("min", today);
                datefino.setAttribute("min", today);

                // Quando cambia la data di inizio, aggiorna la data di fine minima
                dateinizio.addEventListener("change", function() {
                    // Reimposta datefino se è precedente a dateinizio
                    if (datefino.value && datefino.value < this.value) {
                        datefino.value = "";
                    }
                    datefino.setAttribute("min", this.value);
                });
            }
        });
    </script>
@endsection
