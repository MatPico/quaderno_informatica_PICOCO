<?php
// avvia la sessione per gestire le variabili di sessione
session_start();

// verifica se la variabile di sessione 'id_passeggero' è impostata; se non lo è, redirige alla pagina index.html
if (!isset($_SESSION['id_passeggero'])) {
    header("Location: index.html");
    exit();
}

// definisce i dettagli di connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpooling";

// crea una connessione al database utilizzando i parametri definiti sopra
$conn = new mysqli($servername, $username, $password, $dbname);

// verifica se si è verificato un errore durante la connessione al database
if ($conn->connect_error) {
    // se la connessione fallisce, stampa un messaggio di errore e termina l'esecuzione
    die("Connessione fallita: " . $conn->connect_error);
}

// recupera i valori inviati dal modulo di ricerca, con un valore di default vuoto se non inviati
$citta_partenza = $_POST['citta_partenza'] ?? '';
$citta_arrivo = $_POST['citta_arrivo'] ?? '';
$contributo_economico = $_POST['contributo_economico'] ?? '';

// prepara la query SQL per cercare i viaggi attivi con almeno un posto disponibile
$sql = "SELECT v.*, a.id_autista, a.nome AS nome_autista, a.cognome AS cognome_autista
        FROM Viaggio v
        JOIN Autista a ON v.id_autista = a.id_autista
        WHERE v.stato='attivo' AND v.max_posti > 0";

// aggiunge filtri alla query in base ai parametri inviati nel modulo
if (!empty($citta_partenza)) {
    $sql .= " AND v.citta_partenza LIKE '%$citta_partenza%'";
}
if (!empty($citta_arrivo)) {
    $sql .= " AND v.citta_arrivo LIKE '%$citta_arrivo%'";
}
if (!empty($contributo_economico)) {
    $sql .= " AND v.contributo_economico <= $contributo_economico";
}

// esegue la query e memorizza il risultato
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Cerca Viaggi</title>
</head>
<body>
    <h1>Cerca Viaggi</h1>
    <!-- crea un modulo per la ricerca dei viaggi con i parametri di città e contributo economico -->
    <form method="post">
        <label for="citta_partenza">Città di Partenza:</label>
        <input type="text" id="citta_partenza" name="citta_partenza"><br>
        <label for="citta_arrivo">Città di Arrivo:</label>
        <input type="text" id="citta_arrivo" name="citta_arrivo"><br>
        <label for="contributo_economico">Contributo Massimo:</label>
        <input type="number" id="contributo_economico" name="contributo_economico" step="0.01"><br>
        <button type="submit">Cerca</button>
    </form>

    <h2>Risultati</h2>
    <table border="1">
        <tr>
            <th>ID Viaggio</th>
            <th>Città Partenza</th>
            <th>Città Arrivo</th>
            <th>Ora Partenza</th>
            <th>Ora Arrivo</th>
            <th>Tempo Stimato</th>
            <th>Contributo Economico</th>
            <th>Posti Disponibili</th>
            <th>Azioni</th>
            <th>Autista</th>
        </tr>
        <?php
        // verifica se ci sono risultati dalla query
        if ($result->num_rows > 0) {
            // cicla su ogni viaggio trovato e visualizza i dettagli
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row['id_viaggio'] . "</td>
                    <td>" . $row['citta_partenza'] . "</td>
                    <td>" . $row['citta_arrivo'] . "</td>
                    <td>" . $row['ora_partenza'] . "</td>
                    <td>" . $row['ora_arrivo'] . "</td>
                    <td>" . $row['tempo_stimato'] . "</td>
                    <td>" . $row['contributo_economico'] . "</td>
                    <td>" . $row['max_posti'] . "</td>
                    <td><a href='prenota_viaggio.php?id=" . $row['id_viaggio'] . "'>Prenota</a></td>
                    <td>
                        <a href='profilo.php?id=" . $row['id_autista'] . "&ruolo=autista'>
                            <button>Vedi Profilo</button>
                        </a>
                    </td>
                </tr>";
            }
        } else {
            // se non ci sono viaggi, mostra un messaggio informativo
            echo "<tr><td colspan='10'>Nessun viaggio trovato</td></tr>";
        }
        ?>
    </table>
    <br>
    <!-- fornisce un link per tornare alla dashboard, in base al tipo di utente (autista o passeggero) -->
    <a href="<?= isset($_SESSION['id_autista']) ? 'dashboard_autista.php' : (isset($_SESSION['id_passeggero']) ? 'dashboard_passeggero.php' : 'index.html') ?>">Torna alla Dashboard</a>
</body>
</html>
