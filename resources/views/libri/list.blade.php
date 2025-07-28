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
                                                        <a href="{{ route('categorie.libri', $categoria->id) }}">
                                                            <span class="badge bg-gradient-primary me-1">
                                                                {{ $categoria->nome }}
                                                            </span>
                                                        </a>
                                                    @endforeach

                                                </td>
                                                <td class="align-middle text-sm">{{ $libro->autore }}</td>
                                                <td class="align-middle text-sm">{{ $libro->annoPub }}</td>
                                                <td class="align-middle text-sm">{{ $libro->descrizione }}</td>

                                                <td>
                                                    @if ($libro->copertina)
                                                        <img src="{{ asset('storage/' . $libro->copertina) }}"
                                                            alt="Copertina" style="height: 80px; cursor: pointer;"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalCopertina{{ $libro->id }}">

                                                        <!-- Modale -->
                                                        <div class="modal fade" id="modalCopertina{{ $libro->id }}"
                                                            tabindex="-1" aria-labelledby="modalLabel{{ $libro->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="modalLabel{{ $libro->id }}">
                                                                            {{ $libro->titolo }}</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Chiudi"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img src="{{ asset('storage/' . $libro->copertina) }}"
                                                                            alt="Copertina Grande"
                                                                            class="img-fluid rounded">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <a href="{{ asset('storage/' . $libro->copertina) }}"
                                                                            download class="btn btn-primary">
                                                                            📥 Scarica
                                                                        </a>
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Chiudi</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span>Nessuna immagine</span>
                                                    @endif
                                                </td>

                                                <td class="align-middle text-sm">{{ $libro->editor }}</td>

                                                <td class="align-middle d-flex gap-1">
                                                    <a href="{{ route('libri.show', $libro->id) }}"
                                                        class="btn btn-sm btn-info">👁️</a>

                                                    <a href="{{ route('libri.edit', $libro) }}"
                                                        class="btn btn-sm btn-warning">✏️</a>

                                                    <form action="{{ route('libri.destroy', $libro) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('Sei sicuro di voler eliminare questo libro?')"
                                                            class="btn btn-danger btn-sm">
                                                            🗑️
                                                        </button>
                                                    </form>
                                                    {{-- ➕ Aggiungi Copia --}}
                                                    <a href="{{ route('copie.create', $libro->id) }}"
                                                        class="btn btn-sm btn-success">➕ Copia</a>
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
