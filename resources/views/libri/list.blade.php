@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">📚 Lista dei Libri</h6>
                        <a href="{{ route('libri.create') }}" class="btn btn-sm btn-primary">➕ Aggiungi Libro</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if ($libri->count())
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Titolo</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                ISBN</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Categoria</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Autore</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Anno</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Descrizione</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Copertina</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Editore</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($libri as $libro)
                                            <tr>
                                                <td class="align-middle text-sm">{{ $libro->titolo }}</td>
                                                <td class="align-middle text-sm">{{ $libro->isbn }}</td>
                                                <td class="align-middle text-sm">

                                                    @foreach ($libro->categorie as $categoria)
                                                        <span
                                                            class="badge bg-gradient-primary me-1">{{ $categoria->nome }}</span>
                                                    @endforeach
                                                </td>
                                                <td class="align-middle text-sm">{{ $libro->autore }}</td>
                                                <td class="align-middle text-sm">{{ $libro->annoPub }}</td>
                                                <td class="align-middle text-sm">{{ $libro->descrizione }}</td>
                                                <td class="align-middle text-sm">

                                                    @if ($libro->copertina)
                                                        <img src="{{ asset('storage/' . $libro->copertina) }}"
                                                            alt="copertina" width="50">
                                                    @else
                                                        <span>Nessuna immagine</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-sm">{{ $libro->editor }}</td>


                                                <td class="align-middle text-sm">{{ $libro->editore }}</td>
                                                <td class="align-middle">
                                                    <a href="{{ route('libri.edit', $libro) }}"
                                                        class="btn btn-sm btn-warning">✏️</a>
                                                    <form action="{{ route('libri.destroy', $libro) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Sei sicuro?')">🗑️</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $libri->links('pagination::bootstrap-5') }}
                                </div>


                            </div>
                        @else
                            <p class="text-center my-3">📭 Nessun libro trovato.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
