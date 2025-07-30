@extends('layouts.app') {{-- ou 'layouts.soft-ui' selon ton projet --}}

@section('content')
    <div class="container-fluid py-4">

        <!-- Barre de navigation avec avatar et menu -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">📚 Benvenuto nella Biblioteca</h4>

            @auth
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-sm text-dark" id="dropdownUser"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" alt="Avatar"
                            class="avatar avatar-sm rounded-circle me-2">
                        <span>{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n2" aria-labelledby="dropdownUser">
                        <li><a class="dropdown-item border-radius-md" href="{{ route('profile.edit') }}">Profilo</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item border-radius-md">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>

        <!-- Barra di ricerca -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('libri.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cerca un libro...">
                    <button class="btn btn-primary" type="submit">Cerca</button>
                </form>
            </div>
        </div>

        <!-- Link alla lista dei libri -->
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Visualizza la lista completa dei libri</h5>
                    <p class="text-sm text-muted mb-0">Accedi all'elenco e gestisci i libri disponibili.</p>
                </div>
                <a href="{{ route('libri.index') }}" class="btn btn-success">Vai ai Libri</a>
            </div>
        </div>

    </div>
@endsection
