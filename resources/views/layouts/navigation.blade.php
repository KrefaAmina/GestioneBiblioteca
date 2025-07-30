<!-- Navbar principale -->
<nav class="navbar navbar-expand-lg bg-white shadow rounded px-4 py-3 mb-4">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand fw-bold text-primary" href="{{ route('libri.index') }}">
            📚 Biblioteca
        </a>

        <!-- Barre de recherche -->
        <form class="d-flex me-auto w-50" method="GET" action="{{ route('libri.index') }}">
            <input class="form-control me-2" type="search" name="search" value="{{ request('search') }}"
                placeholder="🔍 Cerca titolo, autore, ISBN..." aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Cerca</button>
        </form>

        <!-- Utilisateur connecté -->
        @auth
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                            class="avatar avatar-sm rounded-circle me-2" alt="avatar">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">👤 Profilo</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">🚪 Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        @endauth
    </div>
</nav>
