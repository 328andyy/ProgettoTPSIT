<?php
// Inizializziamo le variabili per gestire i messaggi
$messaggio = "";

// Aspetta che il pulsante venga premuto per eseguire il codice
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Salvataggio dati e rimozione degli spazi vuoti con trim
    $titolo   = trim($_POST['titolo']);
    $autore   = trim($_POST['autore']);
    $formato  = trim($_POST['formato']);
    $genere   = trim($_POST['genere']);
    $isbn     = trim($_POST['isbn']);
    $anno     = trim($_POST['anno']);
    
    // Nome del file di testo dove salveremo il catalogo dei libri
    $file_catalogo = "catalogo.txt";

    // controllo che tutti i campi siano stati compilati
    if (empty($titolo) || empty($autore) || empty($formato) || empty($genere) || empty($isbn) || empty($anno)) {
        $messaggio = "Riempi tutti i campi richiesti";
    } else {
        $libro_esiste = false;

        // Controllo per vedere se il libro esiste gia (basandosi sull'ISBN)
        if (file_exists($file_catalogo)) {
            // Leggiamo il file riga per riga
            $righe = file($file_catalogo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($righe as $riga) {
                // Dividiamo la riga usando il separatore ";"
                $dati = explode(";", $riga);
                
                // Nel formato Titolo;Autore;Formato;Genere;ISBN;Anno, l'ISBN si trova alla posizione [4]
                if (isset($dati[4])) {
                    $isbn_salvato = trim($dati[4]);
                    
                    if ($isbn_salvato === $isbn) {
                        $libro_esiste = true;
                        break;
                    }
                }
            }
        }

        if ($libro_esiste) {
            $messaggio = "Libro gia presente";
        } else {
            // Creazione riga finale da inserire nel file "c"atalogo"
            $nuova_riga = $titolo . ";" . $autore . ";" . $formato . ";" . $genere . ";" . $isbn . ";" . $anno . PHP_EOL;

            // Scrittura riga nel file 
            file_put_contents($file_catalogo, $nuova_riga, FILE_APPEND);

            $messaggio = "Libro inserito correttamente";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Aggiungi Libro</title>
    </head>

    <body>

        <h2>Aggiungi un Nuovo Libro al Catalogo</h2>

        <form action="AggiuntaLibri.php" method="POST">
            
            <p>
                <label>Titolo del libro:</label><br>
                <input type="text" name="titolo" required>
            </p>

            <p>
                <label>Autore:</label><br>
                <input type="text" name="autore" required>
            </p>

            <p>
                <label>Formato:</label><br>
                <select name="formato" required>
                    <option value="Cartaceo">Libro</option>
                    <option value="Ebook">Poesia</option>
                    <option value="Audiolibro">Opera Teatrale</option>
                </select>
            </p>

            <p>
                <label>Genere:</label><br>
                <input type="text" name="genere" required>
            </p>

            <p>
                <label>Codice ISBN:</label><br>
                <input type="text" name="isbn" required>
            </p>

            <p>
                <label>Anno di pubblicazione:</label><br>
                <input name="anno"required>
            </p>

            <button type="submit">Aggiungi Libro</button>
        </form>

        <?php if (!empty($messaggio)): ?>
            <div>
                <?php echo $messaggio; ?>
            </div>
        <?php endif; ?>

    </body>
</html>