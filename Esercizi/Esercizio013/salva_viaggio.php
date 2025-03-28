<?php
session_start();
// verifica se l'autista è loggato, altrimenti reindirizza alla pagina di login
if (!isset($_SESSION['id_autista'])) {
    header("Location: index.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpooling";

// connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // se la connessione fallisce, mostra un errore
    die("Connessione fallita: " . $conn->connect_error);
}

// recupero i dati inviati dal form
$id_autista = $_SESSION['id_autista'];
$citta_partenza = $_POST['citta_partenza'];
$citta_arrivo = $_POST['citta_arrivo'];
$ora_partenza = $_POST['ora_partenza'];
$ora_arrivo = $_POST['ora_arrivo'];
$tempo_stimato = $_POST['tempo_stimato'];
$contributo_economico = $_POST['contributo_economico'];
$max_posti = $_POST['max_posti'];

// query per inserire i dati nel database
$sql = "INSERT INTO Viaggio (id_autista, citta_partenza, citta_arrivo, ora_partenza, ora_arrivo, tempo_stimato, contributo_economico, max_posti, stato) VALUES ('$id_autista', '$citta_partenza', '$citta_arrivo', '$ora_partenza', '$ora_arrivo', '$tempo_stimato', '$contributo_economico', '$max_posti', 'attivo')";

// eseguo la query e controllo se è andata a buon fine
if ($conn->query($sql)) {
    // se il viaggio è stato creato correttamente, mostro un messaggio di successo
    echo "Viaggio creato con successo!";
} else {
    // in caso di errore, mostro il messaggio di errore
    echo "Errore: " . $sql . "<br>" . $conn->error;
}

// chiudo la connessione al database
$conn->close();
?>
<br>
<!-- link per tornare alla dashboard dell'autista o passeggero, a seconda della sessione -->
<a href="<?= isset($_SESSION['id_autista']) ? 'dashboard_autista.php' : (isset($_SESSION['id_passeggero']) ? 'dashboard_passeggero.php' : 'index.html') ?>">Torna alla Dashboard</a>
