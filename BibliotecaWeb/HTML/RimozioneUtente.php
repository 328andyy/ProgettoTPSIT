<?php
// Inizializziamo le variabili per gestire i messaggi
$messaggio = "";

// Aspetta che il pulsante venga premuto per eseguire il codice
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperiamo il dato inviato e togliamo spazi vuoti inutili tramite trim
    $username = trim($_POST['username']);
    
    // Nome del file di testo da cui rimuovere
    $file_utenti = "utenti.txt";

    // Se il nome utente non viene inserito viene mostrato un avviso
    if (empty($username)) {
        $messaggio = "Per favore, inserisci il nome utente.";
    } else {
        $utente_trovato = false;
        $nuove_righe = [];

        // Controlliamo se il file esiste
        if (file_exists($file_utenti)) {
            // Salvataggio del file di testo in un array, in cui ogni elemento è una riga/utente
            $righe = file($file_utenti, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($righe as $riga) {
                // I dati dell'elemento vengono divisi in un sotto-array tramite ":"
                $dati = explode(":", $riga);
                $user_salvato = trim($dati[0]);

                // Se l'utente corrisponde a quello da eliminare
                if ($user_salvato === $username) {
                    $utente_trovato = true;
                    // Serve per saltare il salvataggio dell'utente indesiderato nell file degli utenti
                    continue; 
                }
                
                // Se non è l'utente da eliminare, salva la riga per riscriverla nel file e aggiunge "l'accapo"
                $nuove_righe[] = $riga . PHP_EOL;
            }
        }

        // Gestione dei messaggi e riscrittura del file
        if ($utente_trovato) {
            // Riscriviamo il file con l'array aggiornato (senza l'utente eliminato)
            file_put_contents($file_utenti, implode("", $nuove_righe));
            
            $messaggio = "Utente '" . $username . "' rimosso con successo!";
        } else {
            // Messaggio se l'utente NON è presente nel file di testo
            $messaggio = 'Nome utente non presente, riprova';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rimuovi Utente</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <h2>Rimozione Utente</h2>

        <form action="RimozioneUtente.php" method="POST">
            <label for="username">Nome utente da rimuovere:</label>
            <input type="text" name="username" id="username" required>

            <button type="submit">Elimina Utente</button>
        </form>

        <?php if (!empty($messaggio)): ?>
        <div>
            <?php echo $messaggio; ?>
        </div>
        <?php endif; ?>

    </body>
</html>