<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sezione Libri - Giallo</title>
    <link rel="stylesheet" href="../../CSS/Style.css">
    <link rel="stylesheet" href="../../CSS/Libro/StyleGiallo.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

    <img src="../../Immagini/Giallo.jpg" class="sfondo-giallo" alt="Sfondo Giallo">

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
                        <li><a href="Avventura.php">Avventura</a></li>
                        <li><a href="Biografico.php">Biografico</a></li>
                        <li><a href="Fantasy.php">Fantasy</a></li>
                        <li><a href="Giallo.php">Giallo</a></li>
                        <li><a href="Horror.php">Horror</a></li>
                        <li><a href="Narrativa.php">Narrativa</a></li>
                        <li><a href="Rosa.php">Rosa</a></li>
                        <li><a href="Storico.php">Storico</a></li>
                        <li><a href="Umoristico.php">Umoristico</a></li>
                    </ul>
                </nav>
                
                <label for="toggle-categorie" class="cat-overlay"></label>
            </div>
            <div class="logo">
                <h1>📚 Giallo</h1>
            </div>
            <nav id="navbar">
                <ul class="nav-links">
                    <li><a href="../Index.php">Home</a></li>
                    <li><a href="../Sezioni.php">Catalogo</a></li>
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
    $file_path = '../../ListaLibri.txt';

    // Inizializza un array vuoto che conterrà solo i libri di genere giallo trovati
    $risultati_giallo = [];

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
                if (strtolower(trim($genere)) === 'giallo') {
                
                    // Se il genere è giallo, aggiunge il libro all'array dei risultati
                    $risultati_giallo[] = [
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
    // Apre lo stesso contenitore usato nella Hero per ereditare gli stili CSS personalizzati
    echo '<div class="php-search-results">';
    echo '<h3>Libri di Genere: giallo</h3>';

    // Se l'array ha trovato libri giallo
    if (!empty($risultati_giallo)) {
        // Apre la lista non ordinata
        echo '<ul>';
    
        // Cicla i libri trovati per stamparli a schermo
        foreach ($risultati_giallo as $libro) {
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
        // Messaggio mostrato nel caso in cui non ci siano libri giallo nel file di testo
        echo '<p>Nessun libro giallo disponibile al momento.</p>';
    }

    // Chiude il contenitore dei risultati
    echo '</div>';
    ?>
</body>
</html>