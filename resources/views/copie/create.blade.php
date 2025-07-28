@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Aggiungi una nuova copia per il libro: <strong>{{ $libro->titolo }}</strong></h2>

        <form action="{{ route('copie.store', $libro->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="stato" class="form-label">Stato</label>
                <select name="stato" id="stato" class="form-select" required>
                    <option value="ottimo" {{ old('stato') == 'ottimo' ? 'selected' : '' }}>Ottimo</option>
                    <option value="buono" {{ old('stato') == 'buono' ? 'selected' : '' }}>Buono</option>
                    <option value="discreto" {{ old('stato') == 'discreto' ? 'selected' : '' }}>Discreto</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="disponibilita" class="form-label">Disponibilità</label>
                <select name="disponibilita" id="disponibilita" class="form-select" required>
                    <option value="disponibile" {{ old('disponibilita') == 'disponibile' ? 'selected' : '' }}>Disponibile
                    </option>
                    <option value="prenotato" {{ old('disponibilita') == 'prenotato' ? 'selected' : '' }}>Prenotato</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea name="note" id="note" rows="3" class="form-control">{{ old('note') }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Salva Copia</button>
        </form>

    </div>
@endsection
