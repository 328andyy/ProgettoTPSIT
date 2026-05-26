<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sezione Libri - Mistery</title>
    <link rel="stylesheet" href="css/style.css"> 
    <link rel="stylesheet" href="css/styleMistery.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

    <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwallpaperaccess.com%2Ffull%2F1583870.jpg&f=1&nofb=1&ipt=19f7dde24d9a63307d0e7b84418498336f39c1418e0d2f3f547f228c98975b64" class="sfondo-fantasy" alt="Sfondo Fantasy Castello">

    <header>
        <div class="container header-container">
            
            <div class="categorie-dropdown">
                <input type="checkbox" id="toggle-categorie" class="cat-checkbox">
                
                <label for="toggle-categorie" class="cat-btn">☰ Generi</label>
                
                <nav class="cat-sidebar">
                    <div class="cat-sidebar-header">
                        <h3>Generi Letterari</h3>
                        <label for="toggle-categorie" class="cat-close">&times;</label>
                    </div>
                    <ul class="cat-list">
                        <li><a href="sezioni.php">Lista Libri</a></li>
                        <li><a href="#giallo">Giallo</a></li>
                        <li><a href="fantasy.php">Fantasy</a></li>
                        <li><a href="#horror">Horror</a></li>
                    </ul>
                </nav>
                
                <label for="toggle-categorie" class="cat-overlay"></label>
            </div>
            <div class="logo">
                <h1>📚 MYSTERY</h1>
            </div>
            <nav id="navbar">
                <ul class="nav-links">
                    <li><a href="Index.php">Home</a></li>
                    <li><a href="#servizi">Servizi</a></li>
                    <li><a href="#contatti">Contatti</a></li>
                    <li><a href="#FAQ">FAQ</a></li>
                </ul>
            </nav>
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>
    <?php
    // 1. IMPOSTAZIONE DEL PERCORSO FILE
    // Definisce il percorso del file di testo che funge da database
    $file_path = 'ListaLibri.txt';

    // Inizializza un array vuoto che conterrà solo i libri di genere Mystery trovati
    $risultati_mystery = [];

    // 2. LETTURA DEL FILE
    // Controlla se il file esiste sul server per evitare errori fatali di sistema
    if (file_exists($file_path)) {
    
        // Legge il file e lo trasforma in un array di righe. 
        // FILE_IGNORE_NEW_LINES: rimuove l'andata a capo alla fine di ogni riga.
        // FILE_SKIP_EMPTY_LINES: salta le righe vuote nel file.
        $righe = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // 3. ELABORAZIONE DEI DATI E FILTRO
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
                $genere = $dati_libro[3]; // Il genere si trova all'indice 3
                $isbn   = $dati_libro[4];
                $anno   = $dati_libro[5];

                // Esegue il controllo sul genere: convertiamo in minuscolo per evitare problemi con maiuscole/miniuscole
                if (strtolower(trim($genere)) === 'mystery') {
                
                    // Se il genere è Mystery, aggiunge il libro all'array dei risultati
                    $risultati_mystery[] = [
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
    echo '<div class="php-search-results">';
    echo '<h3>Libri di Genere: Mystery</h3>';

    // Se l'array ha trovato libri mystery
    if (!empty($risultati_mystery)) {
        // Apre la lista non ordinata
        echo '<ul>';
    
        // Cicla i libri trovati per stamparli a schermo
        foreach ($risultati_mystery as $libro) {
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
        // Messaggio mostrato nel caso in cui non ci siano libri fantasy nel file di testo
        echo '<p>Nessun libro mystery disponibile al momento.</p>';
    }

    // Chiude il contenitore dei risultati
    echo '</div>';
    ?>
</body>
</html>