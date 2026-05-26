<?php
// Inizializziamo le variabili per gestire i messaggi
$messaggio = "";

// Aspetta che il pulsante venga premuto per eseguire il codice
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperiamo i dati inviati e togliamo spazi vuoti inutili tramite trim
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Nome del file di testo da cui leggere i dati
    $file_utenti = "utenti.txt";

    // Se il nome utente o la password non vengono inseriti viene mostrato un avviso
    if (empty($username) || empty($password)) {
        $messaggio = "Per favore, compila tutti i campi.";
    } else {
        $utente_trovato = false;
        $password_corretta = false;

        // Controlliamo se il file esiste
        if (file_exists($file_utenti)) {
            // Salvataggio del file di testo in un array, in cui ogni elemento è una riga/utente
            $righe = file($file_utenti, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($righe as $riga) {
                // I dati dell'elemento vengono divisi in un sotto-array tramite ":"
                $dati = explode(":", $riga);
                $user_salvato = $dati[0];
                $password_salvata = $dati[1];

                // Se troviamo corrispondenza con l'username
                if ($user_salvato === $username) {
                    $utente_trovato = true;
                    
                    // Controlliamo anche se la password coincide
                    if ($password_salvata === $password) {
                        $password_corretta = true;
                    }
                    break; // Utente trovato, possiamo uscire dal ciclo
                }
            }
        }

        // Gestione dei messaggi in base ai controlli
        if (!$utente_trovato) {
            // Messaggio se l'utente NON è presente nel file di testo
            $messaggio = 'Nome utente non presente, vuoi <a href="registrati.php">registrarti</a>?';
        } else {
            if ($password_corretta) {
                $messaggio = "Accesso eseguito con successo! Benvenuto, " . htmlspecialchars($username) . ".";
            } else {
                $messaggio = "Password errata. Riprova.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accedi</title>
        <link rel="stylesheet" href="../CSS/styleLogin.css">
    </head>

    <body>

        <div class="login-container">
            <h2>Accesso Utente</h2>

            <form action="Accedi.php" method="POST">
                <label for="username">Nome utente:</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>

                <button type="submit">Accedi</button>
            </form>

            <?php if (!empty($messaggio)): ?>
            <div class="messaggio">
                <?php echo $messaggio; ?>
            </div>
            <?php endif; ?>
        </div>

    </body>
</html>