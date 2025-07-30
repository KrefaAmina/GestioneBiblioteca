@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-lg rounded-3 border-0">
            <!-- Intestazione grigia chiara -->
            <div class="card-header bg-light text-secondary fw-bold">
                Copie disponibili per il libro: {{ $libro->titolo }}
            </div>
            <div class="card-body">
                <p>Periodo selezionato: dal <strong>{{ $dateinizio }}</strong> al <strong>{{ $datefino }}</strong></p>

                @if ($copie->isEmpty())
                    <p class="text-danger">❌ Nessuna copia disponibile in questo periodo.</p>
                @else
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-secondary text-xs font-weight-bold">Codice a Barre</th>
                                    <th class="text-secondary text-xs font-weight-bold">Stato</th>
                                    <th class="text-secondary text-xs font-weight-bold">Note</th>
                                    <th class="text-secondary text-xs font-weight-bold">Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($copie as $copia)
                                    <tr>
                                        <td class="text-sm">{{ $copia->codice_barre }}</td>
                                        <td class="text-sm">{{ ucfirst($copia->stato->value) }}</td>
                                        <td class="text-sm">{{ $copia->note }}</td>
                                        <td class="text-sm">
                                            <a href="#" class="btn btn-primary btn-sm btn-prenota"
                                                data-bs-toggle="modal" data-bs-target="#prenotaModal"
                                                data-copia-id="{{ $copia->id }}"
                                                data-codice-barre="{{ $copia->codice_barre }}"
                                                data-libro-titolo="{{ $libro->titolo }}"
                                                data-date-inizio="{{ $dateinizio }}"
                                                data-date-fino="{{ $datefino }}">
                                                📘 Prenota questa copia
                                            </a>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <a href="{{ route('libri.show', $libro->id) }}" class="btn btn-secondary mt-4">← Torna al libro</a>
            </div>
        </div>
    </div>

    <!-- Modale di conferma prenotazione -->
    <div class="modal fade" id="prenotaModal" tabindex="-1" aria-labelledby="prenotaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg rounded-3">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="prenotaModalLabel">Conferma Prenotazione</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Codice a Barre:</strong> <span id="modalCodiceBarre"></span></p>
                    <p><strong>Libro:</strong> <span id="modalLibroTitolo"></span></p>
                    <p><strong>Periodo:</strong> <span id="modalPeriodo"></span></p>
                    <p>Sei sicuro di voler prenotare questa copia?</p>
                </div>
                <div class="modal-footer">
                    <button id="btnConfermaPrenotazione" class="btn btn-success">Sì</button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Torna alla lista</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Apertura della sezione scripts --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Quando si clicca su un pulsante "Prenota"
            document.querySelectorAll('.btn-prenota').forEach(function(button) {
                button.addEventListener('click', function() {
                    // 📦 Recupero dei dati dagli attributi del pulsante
                    const libroTitolo = this.getAttribute('data-libro-titolo');
                    const dateInizio = this.getAttribute('data-date-inizio');
                    const dateFino = this.getAttribute('data-date-fino');
                    const copiaId = this.getAttribute('data-copia-id');
                    const codiceBarre = this.getAttribute('data-codice-barre');

                    // 👉 Log dei dati ottenuti dal pulsante per debug
                    console.log('DEBUG:', {
                        libroTitolo,
                        dateInizio,
                        dateFino,
                        copiaId,
                        codiceBarre
                    });

                    // 📝 Aggiorno il contenuto della modale
                    document.getElementById('modalCodiceBarre').textContent = codiceBarre;
                    document.getElementById('modalLibroTitolo').textContent = libroTitolo;
                    document.getElementById('modalPeriodo').textContent =
                        `${dateInizio} - ${dateFino}`;

                    // 🔗 Imposto l'URL del pulsante di conferma
                    document.getElementById('btnConfermaPrenotazione').addEventListener('click',
                        function() {
                            if (selectedCopiaId && selectedDateInizio && selectedDateFino) {
                                window.location.href =
                                    `/prenotazioni/store-and-redirect?copia_id=${selectedCopiaId}&dateinizio=${selectedDateInizio}&datefino=${selectedDateFino}`;
                            } else {
                                alert("Errore: dati mancanti per la prenotazione.");
                            }
                        });
                });
            });
        });
    </script>
@endsection
