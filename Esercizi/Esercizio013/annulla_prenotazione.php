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

// recupera l'ID della prenotazione dalla query string (GET)
$id_prenotazione = $_GET['id'];

// prepara la query SQL per annullare la prenotazione cambiando lo stato a 'rifiutata'
$sql = "UPDATE prenotazione SET stato='rifiutata' WHERE id_prenotazione='$id_prenotazione'";

// esegue la query e verifica se è stata eseguita correttamente
if ($conn->query($sql)) {
    // se la query è stata eseguita con successo, stampa un messaggio di successo
    echo "Prenotazione annullata con successo!";
} else {
    // se la query fallisce, stampa l'errore generato
    echo "Errore: " . $sql . "<br>" . $conn->error;
}

// chiude la connessione al database
$conn->close();
?>
<br>
<!-- fornisce un link per tornare alla dashboard, in base al tipo di utente (autista o passeggero) -->
<a href="<?= isset($_SESSION['id_autista']) ? 'dashboard_autista.php' : (isset($_SESSION['id_passeggero']) ? 'dashboard_passeggero.php' : 'index.html') ?>">Torna alla Dashboard</a>
