<?php
session_start(); // avvia la sessione per mantenere i dati dell'utente

// verifica se l'utente è autenticato come autista o passeggero
if (!isset($_SESSION['id_autista']) && !isset($_SESSION['id_passeggero'])) {
    // se l'utente non è loggato, lo reindirizza alla pagina di login
    header("Location: index.html");
    exit();
}

// dati di connessione al database
$servername = "localhost"; // nome del server database (localhost per ambiente locale)
$username = "root"; // nome utente del database
$password = ""; // password del database (vuota in molti ambienti locali)
$dbname = "carpooling"; // nome del database

// creazione della connessione al database mysql
$conn = new mysqli($servername, $username, $password, $dbname);

// verifica se la connessione è andata a buon fine
if ($conn->connect_error) {
    die("connessione fallita: " . $conn->connect_error); // messaggio di errore se la connessione fallisce
}

// recupera l'id del viaggio passato come parametro nell'url (es. dettagli_viaggio.php?id=3)
$id_viaggio = $_GET['id']; 

// determina il ruolo dell'utente in base alla sessione attiva (autista o passeggero)
$ruolo = isset($_SESSION['id_autista']) ? 'autista' : 'passeggero';

// query sql per ottenere tutti i dettagli del viaggio specificato
$sql_viaggio = "SELECT * FROM Viaggio WHERE id_viaggio='$id_viaggio'";
$result_viaggio = $conn->query($sql_viaggio); // esegue la query
$viaggio = $result_viaggio->fetch_assoc(); // converte il risultato in un array associativo

// controlla se il viaggio esiste
if (!$viaggio) {
    die("viaggio non trovato."); // se il viaggio non esiste, mostra un messaggio di errore
}

// se l'utente è un autista, recupera l'elenco dei passeggeri che hanno prenotato il viaggio
if ($ruolo == 'autista') {
    $sql_passeggeri = "SELECT p.id_passeggero, p.nome, p.cognome, pr.id_prenotazione, pr.stato 
                       FROM prenotazione pr 
                       JOIN passeggero p ON pr.id_passeggero = p.id_passeggero 
                       WHERE pr.id_viaggio='$id_viaggio'";
    $result_passeggeri = $conn->query($sql_passeggeri); // esegue la query per ottenere i passeggeri
}

// se l'utente è un autista ed ha inviato un modulo per modificare lo stato del viaggio
if ($ruolo == 'autista' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuovo_stato = $_POST['stato']; // recupera il nuovo stato selezionato dal modulo

    // query per aggiornare lo stato del viaggio nel database
    $sql_update_stato = "UPDATE Viaggio SET stato='$nuovo_stato' WHERE id_viaggio='$id_viaggio'";
    
    if ($conn->query($sql_update_stato)) { // se l'aggiornamento è riuscito
        // se il viaggio viene chiuso o cancellato, aggiornare anche lo stato delle prenotazioni associate
        if ($nuovo_stato == 'chiuso') {
            $sql_update_prenotazioni = "UPDATE prenotazione SET stato='chiusa' WHERE id_viaggio='$id_viaggio'";
        } elseif ($nuovo_stato == 'cancellato') {
            $sql_update_prenotazioni = "UPDATE prenotazione SET stato='cancellata' WHERE id_viaggio='$id_viaggio'";
        }

        // esegue l'aggiornamento dello stato delle prenotazioni se necessario
        if (isset($sql_update_prenotazioni) && $conn->query($sql_update_prenotazioni)) {
            $messaggio = "stato del viaggio e prenotazioni aggiornati con successo!";
        } else {
            $errore = "errore durante l'aggiornamento delle prenotazioni: " . $conn->error;
        }

        // ricarica i dati del viaggio aggiornati
        $result_viaggio = $conn->query($sql_viaggio);
        $viaggio = $result_viaggio->fetch_assoc();
    } else {
        $errore = "errore durante l'aggiornamento dello stato del viaggio: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>dettagli viaggio</title>
</head>
<body>
    <h1>dettagli viaggio</h1>

    <!-- mostra eventuali messaggi di successo o errore -->
    <?php if (isset($messaggio)) echo "<p style='color:green;'>$messaggio</p>"; ?>
    <?php if (isset($errore)) echo "<p style='color:red;'>$errore</p>"; ?>

    <h2>informazioni viaggio</h2>
    <!-- mostra le informazioni principali del viaggio -->
    <p><strong>città di partenza:</strong> <?= $viaggio['citta_partenza'] ?></p>
    <p><strong>città di arrivo:</strong> <?= $viaggio['citta_arrivo'] ?></p>
    <p><strong>ora di partenza:</strong> <?= $viaggio['ora_partenza'] ?></p>
    <p><strong>ora di arrivo:</strong> <?= $viaggio['ora_arrivo'] ?></p>
    <p><strong>tempo stimato:</strong> <?= $viaggio['tempo_stimato'] ?></p>
    <p><strong>contributo economico:</strong> <?= $viaggio['contributo_economico'] ?> €</p>
    <p><strong>posti disponibili:</strong> <?= $viaggio['max_posti'] ?></p>
    <p><strong>stato:</strong> <?= $viaggio['stato'] ?></p>

    <?php if ($ruolo == 'autista'): ?>
        <h2>passeggeri prenotati</h2>
        <!-- mostra la lista dei passeggeri prenotati -->
        <?php if ($result_passeggeri->num_rows > 0): ?>
            <table border="1">
                <tr>
                    <th>nome</th>
                    <th>cognome</th>
                    <th>stato prenotazione</th>
                    <th>azioni</th>
                </tr>
                <?php while ($row = $result_passeggeri->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['nome'] ?></td>
                        <td><?= $row['cognome'] ?></td>
                        <td><?= $row['stato'] ?></td>
                        <td>
                            <a href="profilo.php?id=<?= $row['id_passeggero'] ?>&ruolo=passeggero">vedi profilo</a>
                            <?php if ($viaggio['stato'] == 'attivo'): ?>
                                | <a href="rifiuta_prenotazione.php?id_prenotazione=<?= $row['id_prenotazione'] ?>">rifiuta</a>
                            <?php elseif ($viaggio['stato'] == 'chiuso'): ?>
                                | <a href="valuta.php?id_passeggero=<?= $row['id_passeggero'] ?>&id_viaggio=<?= $id_viaggio ?>">valuta</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>nessun passeggero prenotato per questo viaggio.</p>
        <?php endif; ?>

        <h2>cambia stato del viaggio</h2>
        <!-- modulo per modificare lo stato del viaggio -->
        <form method="post">
            <label for="stato">nuovo stato:</label>
            <select id="stato" name="stato" required>
                <option value="attivo">attivo</option>
                <option value="chiuso">chiuso</option>
                <option value="cancellato">cancellato</option>
            </select><br>
            <button type="submit">aggiorna stato</button>
        </form>
    <?php endif; ?>

    <!-- link per tornare alla dashboard -->
    <br>
    <a href="<?= $ruolo == 'autista' ? 'dashboard_autista.php' : 'dashboard_passeggero.php' ?>">torna alla dashboard</a>
</body>
</html>
