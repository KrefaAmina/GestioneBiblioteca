@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">{{ $libro->titolo }}</h2>

        <div class="row">
            <div class="col-md-4">
                @if ($libro->copertina)
                    <img src="{{ asset('storage/' . $libro->copertina) }}" class="img-fluid rounded shadow"
                        alt="{{ $libro->titolo }}">
                @else
                    <img src="https://via.placeholder.com/300x400?text=Nessuna+Copertina" class="img-fluid rounded shadow"
                        alt="Placeholder">
                @endif
            </div>

            <div class="col-md-8">
                <p><strong>Autore:</strong> {{ $libro->autore }}</p>
                <p><strong>ISBN:</strong> {{ $libro->isbn }}</p>
                <p><strong>Descrizione:</strong> {{ $libro->descrizione }}</p>
                <p><strong>Anno:</strong> {{ $libro->annoPub }}</p>
                <p><strong>Editore:</strong> {{ $libro->editor }}</p>
                <p><strong>Categorie:</strong>
                    @foreach ($libro->categorie as $categoria)
                        <a href="{{ route('categorie.libri', $categoria->id) }}" class="badge bg-primary text-white me-1">
                            {{ $categoria->nome }}
                        </a>
                    @endforeach
                </p>

                <div class="mt-4 d-flex gap-2">
                    <!-- Bouton Prenota -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#prenotaModal">
                        📆 Prenota
                    </button>

                    <a href="{{ route('libri.index') }}" class="btn btn-secondary">← Torna alla lista</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale Prenotazione -->
    <div class="modal fade" id="prenotaModal" tabindex="-1" aria-labelledby="prenotaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Scegli il periodo di prenotazione</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body">
                    <form id="formPrenotazione">
                        <input type="hidden" name="libro_id" value="{{ $libro->id }}">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="dateinizio" class="form-label">Data Inizio</label>
                                <input type="date" class="form-control" name="dateinizio" required>
                            </div>
                            <div class="col">
                                <label for="datefino" class="form-label">Data Fine</label>
                                <input type="date" class="form-control" name="datefino" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">🔍 Cerca Copie</button>
                    </form>


                    <!-- Risultato -->
                    <div id="copieDisponibili" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date().toISOString().split("T")[0];
            document.querySelector('input[name="dateinizio"]').min = today;
            document.querySelector('input[name="datefino"]').min = today;

            document.querySelector('input[name="dateinizio"]').addEventListener("change", function() {
                document.querySelector('input[name="datefino"]').min = this.value;
            });
        });

        document.getElementById('formPrenotazione').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const data = {
            dateinizio: form.dateinizio.value,
            datefino: form.datefino.value,
            libro_id: form.libro_id.value
        };

        fetch("{{ route('copie.disponibili') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                const container = document.getElementById('copieDisponibili');
                if (data.length === 0) {
                    container.innerHTML =
                        '<p class="text-danger">❌ Nessuna copia disponibile in quel periodo.</p>';
                } else {
                    const statoOrder = {
                        'ottimo': 1,
                        'buono': 2,
                        'discreto': 3
                    };
                    data.sort((a, b) => statoOrder[a.stato] - statoOrder[b.stato]);

                    let html =
                        '<h6>📖 Copie disponibili:</h6><table class="table table-bordered"><thead><tr><th>Codice a Barre</th><th>Stato</th><th>Azioni</th></tr></thead><tbody>';
                    data.forEach(copia => {
                        html += `<tr>
                        <td>${copia.codice_barre}</td>
                        <td>${copia.stato.charAt(0).toUpperCase() + copia.stato.slice(1)}</td>
                        
                        <td><a href="/prenotazioni/create?copia_id=${copia.id}" class="btn btn-sm btn-primary">Prenota</a></td>
                    </tr>`;
                    });
                    html += '</tbody></table>';
                    container.innerHTML = html;
                }
            })
            .catch(err => {
                console.error(err);
                alert("Errore durante la ricerca delle copie.");
            });
        });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Prend la data di oggi nel formato 'YYYY-MM-DD'
            const today = new Date().toISOString().split("T")[0];

            // Seleziona gli input per le date
            const dataInizio = document.getElementById('data_inizio');
            const dataFine = document.getElementById('data_fine');

            // Imposta il minimo selezionabile su oggi per entrambe le date
            dataInizio.setAttribute('min', today);
            dataFine.setAttribute('min', today);

            // Quando l'utente cambia la data di inizio...
            dataInizio.addEventListener('change', function() {
                const selectedStart = this.value;

                // Reset della data fine se era impostata prima
                dataFine.value = "";

                // Imposta il minimo selezionabile per la data di fine
                dataFine.setAttribute('min', selectedStart);
            });
        });

        // Gestione invio form prenotazione con fetch AJAX
        document.getElementById('formPrenotazione').addEventListener('submit', function(e) {
            e.preventDefault(); // Evita ricaricamento pagina

            const form = e.target;

            // Prepara i dati da inviare
            const data = {
                data_inizio: form.data_inizio.value,
                data_fine: form.data_fine.value,
                libro_id: form.libro_id.value
            };

            // Invia richiesta AJAX al server
            fetch("{{ route('copie.disponibili') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}", // Protezione CSRF
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('copieDisponibili');

                    // Nessuna copia disponibile
                    if (data.length === 0) {
                        container.innerHTML =
                            '<p class="text-danger">❌ Nessuna copia disponibile in quel periodo.</p>';
                    } else {
                        // Ordina per stato: ottimo > buono > discreto
                        const statoOrder = {
                            'ottimo': 1,
                            'buono': 2,
                            'discreto': 3
                        };
                        data.sort((a, b) => statoOrder[a.stato] - statoOrder[b.stato]);

                        // Costruisci tabella HTML con le copie disponibili
                        let html =
                            '<h6>📖 Copie disponibili:</h6><table class="table table-bordered"><thead><tr><th>Codice a Barre</th><th>Stato</th><th>Azioni</th></tr></thead><tbody>';
                        data.forEach(copia => {
                            html += `<tr>
                        <td>${copia.codice_barre}</td>
                        <td>${copia.stato.charAt(0).toUpperCase() + copia.stato.slice(1)}</td>
                        <td><a href="/prenotazioni/create?copia_id=${copia.id}" class="btn btn-sm btn-primary">Prenota</a></td>
                    </tr>`;
                        });
                        html += '</tbody></table>';
                        container.innerHTML = html;
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("❌ Errore durante la ricerca delle copie.");
                });
        });
    </script>
@endsection
