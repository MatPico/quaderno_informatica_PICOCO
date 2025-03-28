<?php
session_start(); // avvia la sessione per mantenere i dati dell'utente

// verifica se l'utente è loggato come passeggero, altrimenti lo reindirizza alla pagina di login
if (!isset($_SESSION['id_passeggero'])) {
    header("Location: index.html"); // reindirizzamento alla pagina di login
    exit();
}

// dati per la connessione al database
$servername = "localhost"; // server del database (localhost per ambiente locale)
$username = "root"; // nome utente del database
$password = ""; // password del database (vuota in molti ambienti locali)
$dbname = "carpooling"; // nome del database

// connessione al database mysql
$conn = new mysqli($servername, $username, $password, $dbname);

// verifica se la connessione ha avuto successo
if ($conn->connect_error) {
    die("connessione fallita: " . $conn->connect_error); // messaggio di errore in caso di connessione fallita
}

// recupera l'id del passeggero dalla sessione
$id_passeggero = $_SESSION['id_passeggero']; 

// query sql per ottenere tutte le prenotazioni del passeggero
$sql = "SELECT p.id_prenotazione, v.id_viaggio, v.citta_partenza, v.citta_arrivo, v.ora_partenza, v.ora_arrivo, 
               v.tempo_stimato, v.contributo_economico, p.stato, 
               a.id_autista, a.nome AS nome_autista, a.cognome AS cognome_autista
        FROM prenotazione p 
        JOIN Viaggio v ON p.id_viaggio = v.id_viaggio 
        JOIN Autista a ON v.id_autista = a.id_autista
        WHERE p.id_passeggero='$id_passeggero'";

// esegue la query e memorizza il risultato
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>gestione prenotazioni</title>
</head>
<body>
    <h1>gestione prenotazioni</h1>

    <!-- tabella per mostrare tutte le prenotazioni dell'utente -->
    <table border="1">
        <tr>
            <th>id prenotazione</th>
            <th>città partenza</th>
            <th>città arrivo</th>
            <th>ora partenza</th>
            <th>ora arrivo</th>
            <th>tempo stimato</th>
            <th>contributo economico</th>
            <th>stato</th>
            <th>azioni</th>
            <th>autista</th>
        </tr>
        <?php
        // verifica se ci sono prenotazioni disponibili
        if ($result->num_rows > 0) {
            // iterazione su ogni prenotazione trovata nel database
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row['id_prenotazione'] . "</td>
                    <td>" . $row['citta_partenza'] . "</td>
                    <td>" . $row['citta_arrivo'] . "</td>
                    <td>" . $row['ora_partenza'] . "</td>
                    <td>" . $row['ora_arrivo'] . "</td>
                    <td>" . $row['tempo_stimato'] . "</td>
                    <td>" . $row['contributo_economico'] . " €</td>
                    <td>" . $row['stato'] . "</td>
                    <td>";
                
                // se la prenotazione è attiva, mostra il pulsante per annullarla
                if ($row['stato'] == 'attiva') {
                    echo "<a href='annulla_prenotazione.php?id=" . $row['id_prenotazione'] . "'>annulla</a>";
                } elseif ($row['stato'] == 'chiusa') { // se il viaggio è chiuso, permette di valutare
                    echo "<a href='valuta.php?id_passeggero=" . $id_passeggero . "&id_viaggio=" . $row['id_viaggio'] . "'>valuta</a>";
                }
                
                echo "</td>
                    <td>
                        <!-- pulsante per vedere il profilo dell'autista -->
                        <a href='profilo.php?id=" . $row['id_autista'] . "&ruolo=autista'>
                            <button>vedi profilo</button>
                        </a>
                    </td>
                </tr>";
            }
        } else {
            // se non ci sono prenotazioni, mostra un messaggio nella tabella
            echo "<tr><td colspan='10'>nessuna prenotazione trovata</td></tr>";
        }
        ?>
    </table>

    <br>
    <!-- link per tornare alla dashboard -->
    <a href="<?= isset($_SESSION['id_autista']) ? 'dashboard_autista.php' : (isset($_SESSION['id_passeggero']) ? 'dashboard_passeggero.php' : 'index.html') ?>">torna alla dashboard</a>
</body>
</html>
