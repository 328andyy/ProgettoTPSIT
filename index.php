<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Biblioteca Centrale</title>
    <link rel="stylesheet" href="style.css">
    <!-- Importiamo dei font eleganti da Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Intestazione e Menu -->
    <header>
        <div class="container header-container">
            <div class="logo">
                <h1> Biblioteca Centrale</h1>
            </div>
            <nav id="navbar">
                <ul class="nav-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#catalogo">Catalogo</a></li>
                    <li><a href="#servizi">Servizi</a></li>
                    <li><a href="#contatti">Contatti</a></li>
                </ul>
            </nav>
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

    <!-- Sezione Principale (Hero) -->
    <main>
        <section id="home" class="hero">
            <div class="hero-content">
                <h2>Esplora mondi infiniti, una pagina alla volta.</h2>
                <p>Oltre 50.000 volumi, sale studio silenziose e risorse digitali a tua disposizione.</p>
        
                <form action="" method="GET" class="search-bar">
                    <input type="text" name="query" placeholder="Cerca titolo, autore o ISBN..." value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                    <button type="submit">Cerca</button>
                </form>

                <?php
                // 1. CONTROLLO DI SICUREZZA E INPUT
                // Verifica se il parametro 'query' esiste nell'URL e se non è vuoto (rimuovendo gli spazi bianchi con trim)
                if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
                    
                    // Converte la stringa cercata in minuscolo per rendere la ricerca case-insensitive (non fa distinzione tra maiuscole/minuscole)
                    $cerca = strtolower(trim($_GET['query']));
                    
                    // Definisce il percorso del file di testo che funge da database
                    $file_path = 'ListaLibri.txt';
                    
                    // Inizializza un array vuoto che conterrà i libri trovati
                    $risultati = [];

                    // 2. LETTURA DEL FILE
                    // Controlla se il file esiste sul server per evitare errori fatali di sistema
                    if (file_exists($file_path)) {
                        
                        // Legge il file e lo trasforma in un array di righe. 
                        // FILE_IGNORE_NEW_LINES: rimuove l'andata a capo alla fine di ogni riga.
                        // FILE_SKIP_EMPTY_LINES: salta le righe vuote nel file.
                        $righe = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                        // 3. ELABORAZIONE DEI DATI E RICERCA
                        // Cicla attraverso ogni singola riga del file di testo
                        foreach ($righe as $riga) {
                            
                            // Esplode (divide) la stringa della riga in un array usando il punto e virgola ';' come separatore
                            $dati_libro = explode(';', $riga);

                            // Controlla che la riga contenga almeno i 6 campi previsti (Titolo, Autore, Tipo, Genere, ISBN, Anno)
                            if (count($dati_libro) >= 6) {
                                // Assegna ogni elemento dell'array a una variabile specifica per fare ordine
                                $titolo = $dati_libro[0];
                                $autore = $dati_libro[1];
                                $tipo   = $dati_libro[2];
                                $genere = $dati_libro[3];
                                $isbn   = $dati_libro[4];
                                $anno   = $dati_libro[5];

                                // Esegue il controllo (strpos): verifica se la stringa cercata è presente 
                                // nel titolo, nell'autore o nell'ISBN (tutto convertito in minuscolo)
                                if (strpos(strtolower($titolo), $cerca) !== false || 
                                    strpos(strtolower($autore), $cerca) !== false || 
                                    strpos(strtolower($isbn), $cerca) !== false) {
                                    
                                    // Se c'è una corrispondenza, aggiunge un array associativo con i dati del libro all'array dei risultati
                                    $risultati[] = [
                                        'titolo' => $titolo,
                                        'autore' => $autore,
                                        'tipo'   => $tipo,
                                        'genere' => $genere,
                                        'isbn'   => $isbn,
                                        'anno'   => $anno
                                    ];
                                }
                            }
                        }
                    }

                    // 4. GENERAZIONE DELL'OUTPUT HTML
                    // Apre un contenitore per i risultati, utile per la formattazione CSS
                    echo '<div class="php-search-results">';
                    
                    // Mostra il titolo della ricerca. htmlspecialchars evita attacchi XSS sanificando l'input
                    echo '<h3>Risultati per: ' . htmlspecialchars($_GET['query']) . '</h3>';

                    // Se l'array dei risultati contiene almeno un libro
                    if (!empty($risultati)) {
                        // Apre la lista non ordinata
                        echo '<ul>';
                        
                        // Cicla i libri trovati per stamparli a schermo
                        foreach ($risultati as $libro) {
                            echo '<li>';
                            // Stampa Titolo e Autore
                            echo '<strong>' . htmlspecialchars($libro['titolo']) . '</strong> - ' . htmlspecialchars($libro['autore']) . '<br>';
                            // Stampa Genere e Anno di pubblicazione
                            echo 'Genere: ' . htmlspecialchars($libro['genere']) . ' (' . htmlspecialchars($libro['anno']) . ')<br>';
                            // Stampa il codice ISBN in piccolo
                            echo '<small>ISBN: ' . htmlspecialchars($libro['isbn']) . '</small>';
                            echo '</li>';
                        }
                        
                        // Chiude la lista
                        echo '</ul>';
                    } else {
                        // Messaggio mostrato nel caso in cui la ricerca non produca risultati
                        echo '<p>Nessun risultato trovato.</p>';
                    }
                    
                    // Chiude il contenitore dei risultati
                    echo '</div>';
                }
                ?>

            </div>
        </section>

        <!-- Sezione Servizi -->
        <section id="servizi" class="services">
            <div class="container">
                <h2 class="section-title">I Nostri Servizi</h2>
                <div class="services-grid">
                    <div class="service-card">
                        <h3>📖 Prestito Libri</h3>
                        <p>Ritira i tuoi libri preferiti e tienili per 30 giorni. Rinnovo disponibile online.</p>
                    </div>
                    <div class="service-card">
                        <h3>💻 Aule Studio & Wi-Fi</h3>
                        <p>Spazi silenziosi e connessione internet in fibra ottica gratuita per tutti gli iscritti.</p>
                    </div>
                    <div class="service-card">
                        <h3>👶 Area Ragazzi</h3>
                        <p>Una sezione dedicata ai più piccoli con libri illustrati e laboratori di lettura.</p>
                    </div>
                    <div class="service-card">
                        <h3>📱 Risorse Digitali</h3>
                        <p>Accedi al nostro catalogo di eBook, audiolibri e riviste digitali comodamente da casa.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="contatti">
        <div class="container footer-content">
            <div class="footer-info">
                <h3>Biblioteca Centrale</h3>
                <p>Via dei Lettori, 123 - 00100 Città</p>
                <p>Email: info@bibliotecacentrale.it</p>
                <p>Telefono: +39 012 3456789</p>
            </div>
            <div class="footer-hours">
                <h3>Orari di Apertura</h3>
                <p>Lun - Ven: 08:30 - 19:30</p>
                <p>Sabato: 09:00 - 13:00</p>
                <p>Domenica: Chiuso</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Biblioteca Centrale. Tutti i diritti riservati.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>