@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Libri della categoria: {{ $categoria->nome }}</h2>

    @if ($libri->count())
        <ul>
            @foreach ($libri as $libro)
                <li>{{ $libro->titolo }} - {{ $libro->autore }}</li>
            @endforeach
        </ul>

        {{ $libri->links() }} {{-- pagination --}}
    @else
        <p>Nessun libro trovato per questa categoria.</p>
    @endif

    <a href="{{ route('categorie') }}" class="btn btn-secondary mt-3">Indietro alla lista categorie</a>
</div>
@endsection
