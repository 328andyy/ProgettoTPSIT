<?php
// Inizializziamo le variabili per gestire i messaggi
$messaggio = "";

// Aspetta che il pulsante viene premuto per eseguire il codice (nel mentre lo salva nel server)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperiamo i dati inviati e togliamo spazi vuoti inutili tramite trim
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Nome del file di testo dove salveremo i dati
    $file_utenti = "utenti.txt";

    //Se il nome utente o la password non vengono inseriti viene mostrato un avviso
    if (empty($username) || empty($password)) {
        $messaggio = "Per favore, compila tutti i campi.";
    } else {
        $utente_esiste = false;

        // Se il file esiste gia, controlliamo se l'username e presente
        if (file_exists($file_utenti)) {
            // Salvataggio del file di testo in un'arrai, in cui ogni elemento e una riga/utente
            $righe = file($file_utenti, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($righe as $riga) {
                // I dati dell'elemento vengono divisi in un sotto array (dividendoli tramite ":") in cui l'elemento 0 e l'username
                $dati = explode(":", $riga);
                $user_salvato = $dati[0];

                // Se troviamo corrispondenza, l'utente esiste gia
                if ($user_salvato === $username) {
                    $utente_esiste = true;
                    break;
                }
            }
        }

        if ($utente_esiste) {
            // Messaggio se l'utente e gia presente
            $messaggio = 'Utente già presente, vuoi <a href="Accedi.html">accedere</a>?';
        } else {
            // Riga da salvare (formato username:password)
            $nuova_riga = $username . ":" . $password . PHP_EOL;

            // Scrittura riga nel file ,FILE_APPEND evita di sovrascrivere il file esistente
            file_put_contents($file_utenti, $nuova_riga, FILE_APPEND);

            $messaggio = "Registrazione eseguita con successo!";
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
        <link rel="stylesheet" href="../css/styleRegistrati.css">
    </head>

    <body>
        <div class="login-container>
            <h2>Registrazione Utente</h2>

            <form action="registrati.php" method="POST">
                <label for="username">Nome utente:</label>
                <input type="text" name="username" id="username" required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>

                <button type="submit">Registrati</button>
            </form>
            <?php if (!empty($messaggio)): ?>
    
            <div class="messaggio">
                <?php echo $messaggio; ?>
            </div>
            <?php endif; ?>
        </div>
    </body>
</html>