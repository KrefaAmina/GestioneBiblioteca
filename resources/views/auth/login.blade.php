<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Login - Biblioteca</title>

    <link rel="stylesheet" href="{{ asset('assets/css/nucleo-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nucleo-svg.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/soft-ui-dashboard.css') }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="bg-gray-100">

    <div class="container my-5">
        <div class="row">
            <!-- Formulaire à gauche -->
            <div class="col-md-6 d-flex flex-column justify-content-center">
                <div class="card shadow-lg">
                    <div class="card-body px-5 py-4">
                        <h4 class="mb-4 text-center">📚 Accesso alla Biblioteca</h4>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                <label class="form-check-label" for="remember">Ricordami</label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Accedi</button>
                            </div>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="{{ route('register') }}">Non hai un account? Registrati</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image à droite -->
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('storage/bib.jfif') }}" alt="Biblioteca" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>

</body>

</html>
