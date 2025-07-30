<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Biblioteca - Benvenuti</title>
    <link rel="stylesheet" href="{{ asset('assets/css/soft-ui-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nucleo-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nucleo-svg.css') }}">
</head>

<body class="g-sidenav-show bg-gray-100">

    <div class="container mt-7">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h1 class="text-primary mb-4">📚 Benvenuti in Biblioteca</h1>
                <p class="lead mb-4">Accedi o registrati per prenotare i tuoi libri preferiti.</p>

                <a href="{{ route('login') }}" class="btn btn-primary me-3">🔐 Connessione</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary">📝 Registrazione</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/soft-ui-dashboard.min.js') }}"></script>
</body>

</html>
