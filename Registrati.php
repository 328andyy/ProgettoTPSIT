<?php
// Inizializziamo le variabili per gestire i messaggi
$messaggio = "";
$classe_messaggio = "";

// Controlliamo se l'utente ha premuto il pulsante "Registrati" (invio del form)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperiamo i dati inviati e togliamo spazi vuoti inutili
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Nome del file di testo dove salveremo i dati
    $file_utenti = "utenti.txt";

    if (empty($username) || empty($password)) {
        $messaggio = "Per favore, compila tutti i campi.";
        $classe_messaggio = "errore";
    } else {
        $utente_esiste = false;

        // Se il file esiste già, controlliamo se l'username è presente
        if (file_exists($file_utenti)) {
            // Leggiamo il file riga per riga
            $righe = file($file_utenti, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($righe as $riga) {
                // Dividiamo la riga usando il separatore ":"
                $dati = explode(":", $riga);
                $user_salvato = $dati[0];

                // Se troviamo corrispondenza, l'utente esiste già
                if ($user_salvato === $username) {
                    $utente_esiste = true;
                    break;
                }
            }
        }

        if ($utente_esiste) {
            // Messaggio richiesto se l'utente è già presente
            $messaggio = 'Utente già presente, vuoi <a href="Accedi.html">accedere</a>?';
            $classe_messaggio = "errore";
        } else {
            // Prepariamo la riga da salvare (formato username:password)
            // NOTA: Per sicurezza reale andrebbe usato password_hash(), ma manteniamo il testo semplice come richiesto
            $nuova_riga = $username . ":" . $password . PHP_EOL;

            // Scriviamo la riga nel file (FILE_APPEND evita di sovrascrivere il file esistente)
            file_put_contents($file_utenti, $nuova_riga, FILE_APPEND);

            $messaggio = "Registrazione eseguita con successo!";
            $classe_messaggio = "successo";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrazione</title>
    </head>

    <body>

        <h2>Registrazione Utente</h2>

        <form action="registrati.php" method="POST" class="form-container">
            <label for="username">Nome utente:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Registrati</button>
        </form>

    <?php if (!empty($messaggio)): ?>
        <div class="messaggio <?php echo $classe_messaggio; ?>">
            <?php echo $messaggio; ?>
        </div>
    <?php endif; ?>

    </body>
</html>