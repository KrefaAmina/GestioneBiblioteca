@extends('layouts.app') {{-- oppure layouts.master, secondo la tua struttura --}}

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h2>📚 Categorie</h2>
                        <a href="{{ route('categorie.createCategoria') }}" class="btn btn-primary">➕ Aggiungi Categoria</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nome
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Descrizione</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categorie as $cat)
                                        <tr>
                                            <td class="align-middle">{{ $cat->nome }}</td>
                                            <td class="align-middle">{{ $cat->descrizione }}</td>
                                            <td class="align-middle d-flex gap-2">
                                                <a href="{{ route('categorie.libri', $cat->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    📖 Lista Libri
                                                </a>

                                                <a href="{{ route('categorie.editCategoria', $cat) }}"
                                                    class="btn btn-sm btn-warning">
                                                    ✏️
                                                </a>

                                                <form action="{{ route('categorie.destroyCategoria', $cat) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Sei sicuro di voler eliminare questa categoria?')">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Nessuna categoria trovata.</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $categorie->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
