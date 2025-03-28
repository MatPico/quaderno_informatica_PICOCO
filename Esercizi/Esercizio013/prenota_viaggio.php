<?php
session_start();  // avvia la sessione per poter utilizzare le variabili di sessione

// verifica se l'utente è loggato come passeggero
if (!isset($_SESSION['id_passeggero'])) {
    header("Location: index.html");  // se non è loggato, reindirizza alla pagina principale
    exit();  // esce dallo script per evitare ulteriori esecuzioni
}

$servername = "localhost";  // definisce il nome del server MySQL
$username = "root";  // definisce il nome utente per la connessione al database
$password = "";  // definisce la password per la connessione al database
$dbname = "carpooling";  // definisce il nome del database

// crea una nuova connessione al database MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// verifica se la connessione al database è riuscita
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);  // se c'è un errore nella connessione, termina l'esecuzione
}

$id_viaggio = $_GET['id'];  // recupera l'id del viaggio dalla query string
$id_passeggero = $_SESSION['id_passeggero'];  // recupera l'id del passeggero dalla sessione

// verifica se ci sono posti disponibili nel viaggio
$sql_viaggio = "SELECT max_posti FROM Viaggio WHERE id_viaggio='$id_viaggio'";  // query SQL per ottenere il numero massimo di posti
$result_viaggio = $conn->query($sql_viaggio);  // esegue la query
$row_viaggio = $result_viaggio->fetch_assoc();  // recupera i risultati in formato associativo

// verifica se ci sono posti disponibili
if ($row_viaggio['max_posti'] > 0) {
    // inserisce la prenotazione per il passeggero
    $sql_prenotazione = "INSERT INTO prenotazione (id_viaggio, id_passeggero, stato) VALUES ('$id_viaggio', '$id_passeggero', 'attiva')";  // query SQL per inserire la prenotazione
    if ($conn->query($sql_prenotazione)) {  // esegue la query di inserimento
        // riduce il numero di posti disponibili per il viaggio
        $sql_update = "UPDATE Viaggio SET max_posti = max_posti - 1 WHERE id_viaggio='$id_viaggio'";  // query SQL per aggiornare i posti disponibili
        $conn->query($sql_update);  // esegue la query di aggiornamento
        echo "Prenotazione effettuata con successo!";  // messaggio di successo
    } else {
        echo "Errore: " . $sql_prenotazione . "<br>" . $conn->error;  // messaggio di errore se la query di prenotazione non riesce
    }
} else {
    echo "Nessun posto disponibile per questo viaggio.";  // messaggio se non ci sono posti disponibili
}

$conn->close();  // chiude la connessione al database
?>
<br>
<!-- link per tornare alla dashboard dell'autista o del passeggero, a seconda di chi è loggato -->
<a href="<?= isset($_SESSION['id_autista']) ? 'dashboard_autista.php' : (isset($_SESSION['id_passeggero']) ? 'dashboard_passeggero.php' : 'index.html') ?>">Torna alla Dashboard</a>
