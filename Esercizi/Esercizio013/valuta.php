<?php
session_start();

// verifica se l'utente è loggato (autista o passeggero), altrimenti reindirizza alla pagina di login
if (!isset($_SESSION['id_autista']) && !isset($_SESSION['id_passeggero'])) {
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

$id_viaggio = $_GET['id_viaggio'] ?? null;
$ruolo = isset($_SESSION['id_autista']) ? 'autista' : 'passeggero';
$messaggio = "";
$errore = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // recupero i dati inviati dal form per la valutazione
    $voto = $_POST['voto'] ?? null;
    $descrizione = $_POST['descrizione'] ?? null;

    if ($ruolo == 'autista') {
        $id_passeggero = $_POST['id_passeggero'] ?? null;

        if ($id_passeggero) {
            // controllo se esiste già una valutazione
            $sql_check = "SELECT * FROM Valutazione 
                          WHERE id_autista='{$_SESSION['id_autista']}' 
                          AND id_passeggero='$id_passeggero' 
                          AND ruolo='autista'";
            $result_check = $conn->query($sql_check);

            if ($result_check->num_rows == 0) {
                // inserisco la valutazione con il ruolo di autista
                $sql_insert = "INSERT INTO Valutazione (id_autista, id_passeggero, voto, descrizione, ruolo) 
                               VALUES ('{$_SESSION['id_autista']}', '$id_passeggero', '$voto', '$descrizione', 'autista')";
                if ($conn->query($sql_insert)) {
                    $messaggio = "Valutazione inviata con successo!";
                } else {
                    $errore = "Errore nell'inserimento della valutazione: " . $conn->error;
                }
            } else {
                // se la valutazione è già stata fatta, mostro un messaggio di errore
                $errore = "Hai già valutato questo passeggero.";
            }
        } else {
            // se non è stato selezionato un passeggero, mostro un messaggio di errore
            $errore = "Seleziona un passeggero da valutare.";
        }
    } else {
        // se il ruolo è 'passeggero', il passeggero valuta l'autista
        $sql_autista = "SELECT id_autista FROM Viaggio WHERE id_viaggio='$id_viaggio'";
        $result_autista = $conn->query($sql_autista);
        $autista = $result_autista->fetch_assoc();

        if ($autista) {
            $id_autista = $autista['id_autista'];

            // controllo se la valutazione esiste già
            $sql_check = "SELECT * FROM Valutazione 
                          WHERE id_autista='$id_autista' 
                          AND id_passeggero='{$_SESSION['id_passeggero']}' 
                          AND ruolo='passeggero'";
            $result_check = $conn->query($sql_check);

            if ($result_check->num_rows == 0) {
                // inserisco la valutazione con il ruolo di passeggero
                $sql_insert = "INSERT INTO Valutazione (id_autista, id_passeggero, voto, descrizione, ruolo) 
                               VALUES ('$id_autista', '{$_SESSION['id_passeggero']}', '$voto', '$descrizione', 'passeggero')";
                if ($conn->query($sql_insert)) {
                    $messaggio = "Valutazione inviata con successo!";
                } else {
                    $errore = "Errore nell'inserimento della valutazione: " . $conn->error;
                }
            } else {
                // se la valutazione è già stata fatta, mostro un messaggio di errore
                $errore = "Hai già valutato questo autista.";
            }
        } else {
            // se non è stato trovato l'autista, mostro un messaggio di errore
            $errore = "Errore nel recupero dei dati dell'autista.";
        }
    }
}

// ottieni i passeggeri per l'autista
if ($ruolo == 'autista') {
    $sql_passeggeri = "SELECT p.id_passeggero, p.nome, p.cognome 
                       FROM prenotazione pr 
                       JOIN passeggero p ON pr.id_passeggero = p.id_passeggero 
                       WHERE pr.id_viaggio='$id_viaggio' AND pr.stato IN ('chiusa', 'attiva')";
    $result_passeggeri = $conn->query($sql_passeggeri);
} else {
    // ottieni i dati dell'autista per il passeggero
    $sql_autista = "SELECT a.id_autista, a.nome, a.cognome 
                    FROM Viaggio v 
                    JOIN autista a ON v.id_autista = a.id_autista 
                    WHERE v.id_viaggio='$id_viaggio'";
    $result_autista = $conn->query($sql_autista);
    $autista = $result_autista->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Valuta</title>
</head>
<body>
    <h1>Valuta</h1>
    
    <?php if ($messaggio): ?>
        <!-- se c'è un messaggio di successo, lo mostro -->
        <p style="color:green;"><?= $messaggio ?></p>
    <?php elseif ($errore): ?>
        <!-- se c'è un errore, lo mostro -->
        <p style="color:red;"><?= $errore ?></p>
    <?php endif; ?>

    <?php if ($ruolo == 'autista'): ?>
        <!-- se l'utente è autista, visualizzo il modulo per valutare i passeggeri -->
        <h2>Valuta i Passeggeri</h2>
        <?php if ($result_passeggeri->num_rows > 0): ?>
            <form method="post">
                <label for="id_passeggero">Seleziona Passeggero:</label>
                <select id="id_passeggero" name="id_passeggero" required>
                    <?php while ($row = $result_passeggeri->fetch_assoc()): ?>
                        <option value="<?= $row['id_passeggero'] ?>">
                            <?= $row['nome'] ?> <?= $row['cognome'] ?>
                        </option>
                    <?php endwhile; ?>
                </select><br>
                <label for="voto">Voto (1-5):</label>
                <input type="number" id="voto" name="voto" min="1" max="5" required><br>
                <label for="descrizione">Descrizione:</label>
                <textarea id="descrizione" name="descrizione" required></textarea><br>
                <button type="submit">Invia Valutazione</button>
            </form>
        <?php else: ?>
            <p>Nessun passeggero trovato per questo viaggio.</p>
        <?php endif; ?>
    <?php else: ?>
        <!-- se l'utente è passeggero, visualizzo il modulo per valutare l'autista -->
        <h2>Valuta l'Autista</h2>
        <?php if ($autista): ?>
            <p>Stai valutando l'autista: <?= $autista['nome'] ?> <?= $autista['cognome'] ?></p>
            <form method="post">
                <label for="voto">Voto (1-5):</label>
                <input type="number" id="voto" name="voto" min="1" max="5" required><br>
                <label for="descrizione">Descrizione:</label>
                <textarea id="descrizione" name="descrizione" required></textarea><br>
                <button type="submit">Invia Valutazione</button>
            </form>
        <?php else: ?>
            <p>Nessun autista trovato per questo viaggio.</p>
        <?php endif; ?>
    <?php endif; ?>
    <br>
    <!-- link per tornare alla dashboard dell'autista o passeggero -->
    <a href="<?= $ruolo == 'autista' ? 'dashboard_autista.php' : 'dashboard_passeggero.php' ?>">Torna alla Dashboard</a>
</body>
</html>
