<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpooling";

// Connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Verifica se è stato fornito un ID prenotazione
$id_prenotazione = $_GET['id_prenotazione'] ?? null;
if (!$id_prenotazione) {
    die("ID prenotazione non fornito.");
}

// Recupero dati della prenotazione (id_viaggio)
$sql_get_prenotazione = "SELECT id_viaggio FROM prenotazione WHERE id_prenotazione = ?";
$stmt = $conn->prepare($sql_get_prenotazione);
$stmt->bind_param("i", $id_prenotazione);
$stmt->execute();
$result = $stmt->get_result();
$prenotazione = $result->fetch_assoc();
$stmt->close();

if (!$prenotazione) {
    die("Prenotazione non trovata.");
}

$id_viaggio = $prenotazione['id_viaggio'];

// Imposta lo stato della prenotazione a "rifiutata"
$sql_update_prenotazione = "UPDATE prenotazione SET stato = 'rifiutata' WHERE id_prenotazione = ?";
$stmt = $conn->prepare($sql_update_prenotazione);
$stmt->bind_param("i", $id_prenotazione);
if (!$stmt->execute()) {
    die("Errore nell'aggiornamento della prenotazione: " . $stmt->error);
}
$stmt->close();

// Incrementa il numero di posti disponibili nel viaggio
$sql_update_viaggio = "UPDATE viaggio SET max_posti = max_posti + 1 WHERE id_viaggio = ?";
$stmt = $conn->prepare($sql_update_viaggio);
$stmt->bind_param("i", $id_viaggio);
if (!$stmt->execute()) {
    die("Errore nell'aggiornamento dei posti disponibili: " . $stmt->error);
}
$stmt->close();

$conn->close();

// Messaggio di conferma e reindirizzamento
echo "<script>
    alert('Prenotazione rifiutata con successo!');
    window.location.href = 'dashboard_autista.php';
</script>";
?>
<br>
<a href="<?= isset($_SESSION['id_autista']) ? 'dashboard_autista.php' : (isset($_SESSION['id_passeggero']) ? 'dashboard_passeggero.php' : 'index.html') ?>">Torna alla Dashboard</a>
