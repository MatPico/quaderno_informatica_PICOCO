<?php
session_start(); // avvia la sessione per mantenere i dati dell'utente loggato

// verifica se l'utente è loggato come autista, altrimenti reindirizza alla pagina di login
if (!isset($_SESSION['id_autista'])) {
    header("Location: index.html"); // reindirizza alla pagina di login se non è loggato
    exit();
}

// dati per la connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpooling";

// connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);

// verifica se la connessione ha avuto successo
if ($conn->connect_error) {
    die("connessione fallita: " . $conn->connect_error); // termina l'esecuzione in caso di errore
}

// ottiene l'id dell'autista dalla sessione
$id_autista = $_SESSION['id_autista'];

// query per selezionare tutti i viaggi associati all'autista loggato
$sql = "SELECT * FROM Viaggio WHERE id_autista='$id_autista'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8"> <!-- definisce il set di caratteri -->
    <title>lista viaggi</title> <!-- titolo della pagina -->
</head>
<body>
    <h1>lista viaggi</h1> <!-- intestazione della pagina -->

    <!-- tabella che mostra i viaggi dell'autista -->
    <table border="1">
        <tr>
            <th>id viaggio</th>
            <th>città partenza</th>
            <th>città arrivo</th>
            <th>ora partenza</th>
            <th>ora arrivo</th>
            <th>tempo stimato</th>
            <th>contributo economico</th>
            <th>posti disponibili</th>
            <th>stato</th>
            <th>azioni</th>
        </tr>

        <?php
        // verifica se ci sono viaggi associati all'autista
        if ($result->num_rows > 0) {
            // stampa ogni viaggio in una riga della tabella
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row['id_viaggio'] . "</td>
                    <td>" . $row['citta_partenza'] . "</td>
                    <td>" . $row['citta_arrivo'] . "</td>
                    <td>" . $row['ora_partenza'] . "</td>
                    <td>" . $row['ora_arrivo'] . "</td>
                    <td>" . $row['tempo_stimato'] . "</td>
                    <td>" . $row['contributo_economico'] . " €</td>
                    <td>" . $row['max_posti'] . "</td>
                    <td>" . $row['stato'] . "</td>
                    <td><a href='dettagli_viaggio.php?id=" . $row['id_viaggio'] . "'>dettagli</a></td>
                </tr>";
            }
        } else {
            // se non ci sono viaggi, mostra un messaggio nella tabella
            echo "<tr><td colspan='10'>nessun viaggio trovato</td></tr>";
        }
        ?>
    </table>

    <br>
    <!-- link per tornare alla dashboard in base al ruolo dell'utente -->
    <a href="<?= isset($_SESSION['id_autista']) ? 'dashboard_autista.php' : (isset($_SESSION['id_passeggero']) ? 'dashboard_passeggero.php' : 'index.html') ?>">
        torna alla dashboard
    </a>
</body>
</html>
