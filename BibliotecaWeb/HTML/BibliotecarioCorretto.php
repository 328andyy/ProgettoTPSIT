<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Bibliotecario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <section class="services">
        <div class="container">
            
            <h1 class="section-title">Area Riservata: Bibliotecario</h1>

            <div class="services-grid">
                <div class="service-card">
                    <button onclick="window.location.href='AggiuntaLibri.php'">Aggiungi Libro</button>
                </div>
                <div class="service-card">
                    <button onclick="window.location.href='RimozioneUtente.php'">Rimuovi Utente</button>
                </div>
                <div class="service-card">
                    <button onclick="window.location.href='NoleggioLibri.php'">Gestisci Prestito</button>
                </div>
            </div>

            <div class="prestiti-container" style="margin-top: 50px;">
                <h2 style="margin-bottom: 15px; color: var(--secondary-color);">Elenco Prestiti Attivi</h2>
                <pre style="white-space: pre-wrap; font-family: var(--font-body);">
                    <?php
                        $file = 'prestito.txt';
                        echo file_exists($file) ? htmlspecialchars(file_get_contents($file)) : "Nessun prestito registrato.";
                    ?>
                </pre>
            </div>

        </div>
    </section>

</body>
</html>