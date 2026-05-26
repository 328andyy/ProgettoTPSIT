<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sezione Libri</title>
    <link rel="stylesheet" href="css/style.css"> 
    <link rel="stylesheet" href="css/styleSezioni.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

    <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwallpaperaccess.com%2Ffull%2F253418.jpg&f=1&nofb=1&ipt=9b646e5e8f2a8fcfe731e2ef64e3f19965d2f453b0b6d3c30763310a77c08e8c" class="sfondo-biblioteca" alt="Sfondo Biblioteca">

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
                        <li><a href="fantasy.php">Fantasy</a></li>
                        <li><a href="#giallo">Giallo</a></li>
                        <li><a href="mystery.php">Mystery</a></li>
                        <li><a href="#horror">Horror</a></li>
                    </ul>
                </nav>
                
                <label for="toggle-categorie" class="cat-overlay"></label>
            </div>
            <div class="logo">
                <h1>📚 Sezione Libri</h1>
            </div>
            <nav id="navbar">
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
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

    // Inizializza un array vuoto che conterrà l'intero catalogo dei libri
    $catalogo_completo = [];

    // 2. LETTURA DEL FILE
    // Controlla se il file esiste sul server per evitare errori fatali di sistema
    if (file_exists($file_path)) {
    
        // Legge il file e lo trasforma in un array di righe.
        $righe = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // 3. ELABORAZIONE DEI DATI
        // Cicla attraverso tutte le righe presenti nel file di testo
        foreach ($righe as $riga) {
    
            // Esplode la stringa usando il punto e virgola ';'
            $dati_libro = explode(';', $riga);

            // Controlla che la riga contenga i 6 campi richiesti per essere considerata valida
            if (count($dati_libro) >= 6) {
            
                // Inserisce direttamente i dati estratti dentro l'array del catalogo, senza filtri o condizioni
                $catalogo_completo[] = [
                    'titolo' => $dati_libro[0],
                    'autore' => $dati_libro[1],
                    'tipo'   => $dati_libro[2],
                    'genere' => $dati_libro[3],
                    'isbn'   => $dati_libro[4],
                    'anno'   => $dati_libro[5]
                ];
            }
        }
    }

    // 4. GENERAZIONE DELL'OUTPUT HTML
    // Sfrutta la classe .php-search-results per mantenere l'allineamento centrale e lo sfondo delle schede
    echo '<div class="php-search-results">';
    echo '<h3>Catalogo Completo dei Libri</h3>';

    // Se il file conteneva dei libri e l'array non è vuoto
    if (!empty($catalogo_completo)) {
        // Apre la lista non ordinata
        echo '<ul>';
    
        // Cicla l'intero array del catalogo per stamparli tutti quanti di fila
        foreach ($catalogo_completo as $libro) {
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
        // Messaggio di sicurezza nel caso in cui il file di testo fosse vuoto
        echo '<p>Il catalogo è attualmente vuoto.</p>';
    }

    // Chiude il contenitore dei risultati
    echo '</div>';
    ?>
</body>
</html>