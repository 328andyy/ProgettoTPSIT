<?php
// Inizializziamo le variabili per gestire i messaggi
$messaggio = "";

// Aspetta che il pulsante venga premuto per eseguire il codice
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Salvataggio dati e rimozione degli spazi vuoti con trim
    $nomeUtente = trim($_POST['nomeUtente']);
    $nomeLibro = trim($_POST['nomeLibro']);
    $dataScadenza = trim($_POST['dataScadenza']);
    $dataPrestito = trim($_POST['dataPrestito']);
    
    // Nome del file di testo dove salveremo il catalogo dei libri
    $file_prestito = "prestito.txt";

    // controllo che tutti i campi siano stati compilati
    if (empty($nomeUtente) || empty($nomeLibro) || empty($dataScadenza) || empty($dataPrestito)) {
        $messaggio = "Riempi tutti i campi richiesti";
    } else {
        $libro_gia_prestato = false;

        // Controllo per vedere se il libro esiste gia (basandosi sull'ISBN)
        if (file_exists($file_prestito)) {
            // Lettura del file riga per riga
            $righe = file($file_prestito, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($righe as $riga) {
                // Dividiamo la riga usando il separatore ";"
                $dati = explode(";", $riga);

                //si prende il primo valore che corrisponde al nome del libro
                if (isset($dati[1])) {
                    $nomeLibro_salvato = trim($dati[1]);
                    
                    if ($nomeLibro_salvato === $nomeLibro) {
                        $libro_gia_prestato = true;
                        break;
                    }
                }
            }
        }

        if ($libro_gia_prestato) {
            $messaggio = "Libro gia prestato";
        } else {
            // Creazione riga finale da inserire nel file "Prestito"
            $nuova_riga = $nomeUtente . ";" . $nomeLibro . ";" . $dataScadenza . ";" . $dataPrestito . PHP_EOL;

            // Scrittura riga nel file 
            file_put_contents($file_prestito, $nuova_riga, FILE_APPEND);

            $messaggio = "Salvataggio del prestito effettuato correttamente";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Aggiungi Prestito</title>
    </head>

    <body>

        <h2>Aggiungi prestito libri</h2>

        <form action="NoleggioLibri.php" method="POST">
            
            <p>
                <label>Nome utente:</label><br>
                <input type="text" name="nomeUtente" required>
            </p>

            <p>
                <label>Nome Libro:</label><br>
                <input type="text" name="nomeLibro" required>
            </p>

             <p>
                <label>Data inizio prestito:</label><br>
                <input type="text" name="dataPrestito" required>
            </p>

            <p>
                <label>Data scadenza prestito:</label><br>
                <input type = "text" name = "dataScadenza" require>
            </p>

            <button type="submit">Aggiungi prestito</button>
        </form>

        <?php if (!empty($messaggio)): ?>
            <div>
                <?php echo $messaggio; ?>
            </div>
        <?php endif; ?>

    </body>
</html>