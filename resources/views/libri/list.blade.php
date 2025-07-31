@extends('layouts.app')

@section('content')


    <!-- Contenu principal -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">📘 Lista dei Libri</h6>
                        @auth
                            @if (Auth::user()->isAdmin())
                                <a href="{{ route('libri.create') }}" class="btn btn-sm btn-primary">➕ Aggiungi Libro</a>
                                <a href="{{ route('categorie') }}" class="btn btn-sm btn-warning">
                                    Categorie
                                </a>
                            @endif
                        @endauth
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>


                                    <!-- En-têtes -->
                                    <tr>

                                        <th>Titolo</th>
                                        <th>Autore</th>
                                        <!-- Filtre interactif -->
                                        <th>
                                            <select id="categoriaFilter" class="form-control form-control-sm"
                                                style="min-width: 80px;">

                                                <option value="">Categoria</option>
                                                @foreach ($categorie as $cat)
                                                    <option
                                                        value="{{ route('libri.index', array_merge(request()->except('page', 'categoria'), ['categoria' => $cat->id])) }}"
                                                        {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </th>

                                        <th>
                                            <select id="annoFilter" class="form-control form-control-sm"
                                                style="min-width: 80px;">
                                                <option value="">Anno</option>
                                                @foreach ($anniDisponibili as $anno)
                                                    <option
                                                        value="{{ route('libri.index', array_merge(request()->except('page', 'anno'), ['anno' => $anno])) }}"
                                                        {{ request('anno') == $anno ? 'selected' : '' }}>
                                                        {{ $anno }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </th>

                                        <th>Copertina</th>
                                        <th>Editore</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($libri as $libro)
                                        <tr>
                                            <td>{{ $libro->titolo }}</td>
                                            <td>{{ $libro->autore }}</td>
                                            <td>
                                                @foreach ($libro->categorie as $categoria)
                                                    <span
                                                        class="badge bg-gradient-primary me-1">{{ $categoria->nome }}</span>
                                                @endforeach
                                            </td>

                                            <td>{{ $libro->annoPub }}</td>

                                            <td>
                                                @if ($libro->copertina)
                                                    <img src="{{ asset('storage/' . $libro->copertina) }}" alt="Copertina"
                                                        style="height: 60px; border-radius: 5px;">
                                                @else
                                                    <span class="text-muted">Nessuna</span>
                                                @endif
                                            </td>
                                            <td>{{ $libro->editor }}</td>
                                            <td class="d-flex gap-1 flex-wrap">
                                                <!-- Bouton Voir (toujours visible) -->
                                                <a href="{{ route('libri.show', $libro->id) }}"
                                                    class="btn btn-sm btn-info">👁️</a>

                                                @auth
                                                    @if (Auth::user()->isAdmin())
                                                        <!-- Bouton Modifier -->
                                                        <a href="{{ route('libri.edit', $libro->id) }}"
                                                            class="btn btn-sm btn-warning">✏️</a>

                                                        <!-- Bouton Ajouter Copia -->
                                                        <a href="{{ route('copie.create', ['libro' => $libro->id]) }}"
                                                            class="btn btn-sm btn-success">➕ Copia</a>
                                                        <!-- Bouton Lista Copie -->
                                                        <a href="{{ route('copie.index', ['libro' => $libro->id]) }}"
                                                            class="btn btn-sm btn-primary">📋 Copie</a>

                                                        <!-- Formulaire Supprimer -->
                                                        <form action="{{ route('libri.destroy', $libro->id) }}" method="POST"
                                                            onsubmit="return confirm('Eliminare questo libro?')"
                                                            style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </td>

                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">📭 Nessun libro trovato.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $libri->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.getElementById('categoriaFilter')?.addEventListener('change', function() {
                if (this.value) window.location.href = this.value;
            });

            document.getElementById('annoFilter')?.addEventListener('change', function() {
                if (this.value) window.location.href = this.value;
            });
        </script>
    @endpush

@endsection
