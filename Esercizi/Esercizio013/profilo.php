<?php
session_start();  // avvia la sessione per poter utilizzare le variabili di sessione

// verifica se l'utente è loggato come autista o passeggero
if (!isset($_SESSION['id_autista']) && !isset($_SESSION['id_passeggero'])) {
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

// Ottieni l'ID dell'utente da visualizzare
$id_utente = $_GET['id'] ?? null;  // recupera l'id dell'utente dalla query string, se presente
if (!$id_utente) {
    die("ID utente non specificato.");  // se non è presente un id, termina l'esecuzione con un errore
}

// Determina il ruolo dell'utente da visualizzare (autista o passeggero)
$ruolo_utente = $_GET['ruolo'] ?? null;  // recupera il ruolo dell'utente dalla query string
if (!$ruolo_utente) {
    die("Ruolo utente non specificato.");  // se non è presente un ruolo, termina l'esecuzione con un errore
}

// Recupera i dati dell'utente in base al ruolo
if ($ruolo_utente == 'autista') {
    $sql_utente = "SELECT a.*, m.colore, m.modello, m.marca, m.anno, m.posti 
                   FROM autista a 
                   JOIN Macchina m ON a.id_macchina = m.id_macchina 
                   WHERE a.id_autista='$id_utente'";  // query per ottenere i dati dell'autista con i dettagli della macchina
} else {
    $sql_utente = "SELECT * FROM passeggero WHERE id_passeggero='$id_utente'";  // query per ottenere i dati del passeggero
}

$result_utente = $conn->query($sql_utente);  // esegue la query per ottenere i dati dell'utente
$utente = $result_utente->fetch_assoc();  // recupera i risultati in formato associativo

if (!$utente) {
    die("Utente non trovato.");  // se non ci sono risultati, termina l'esecuzione con un errore
}

// Ottieni SOLO le valutazioni ricevute da utenti con ruolo opposto
if ($ruolo_utente == 'autista') {
    $sql_valutazioni = "SELECT v.voto, v.descrizione, p.nome, p.cognome 
                        FROM Valutazione v 
                        JOIN passeggero p ON v.id_passeggero = p.id_passeggero 
                        WHERE v.id_autista='$id_utente' AND v.ruolo = 'passeggero'";  // query per ottenere le valutazioni degli autisti dai passeggeri
} else {
    $sql_valutazioni = "SELECT v.voto, v.descrizione, a.nome, a.cognome 
                        FROM Valutazione v 
                        JOIN autista a ON v.id_autista = a.id_autista 
                        WHERE v.id_passeggero='$id_utente' AND v.ruolo = 'autista'";  // query per ottenere le valutazioni dei passeggeri dagli autisti
}

$result_valutazioni = $conn->query($sql_valutazioni);  // esegue la query per ottenere le valutazioni
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">  <!-- definisce il set di caratteri -->
    <title>Profilo</title>  <!-- titolo della pagina -->
</head>
<body>
    <h1>Profilo</h1>

    <!-- Dati dell'utente -->
    <h2>Dati Personali</h2>
    <p><strong>Nome:</strong> <?= $utente['nome'] ?></p>  <!-- mostra il nome dell'utente -->
    <p><strong>Cognome:</strong> <?= $utente['cognome'] ?></p>  <!-- mostra il cognome dell'utente -->
    <p><strong>Email:</strong> <?= $utente['mail'] ?></p>  <!-- mostra l'email dell'utente -->
    <p><strong>Numero:</strong> <?= $utente['numero'] ?></p>  <!-- mostra il numero dell'utente -->

    <!-- Dati auto per gli autisti -->
    <?php if ($ruolo_utente == 'autista'): ?>
        <h2>Dati Auto</h2>
        <p><strong>Colore:</strong> <?= $utente['colore'] ?></p>  <!-- mostra il colore della macchina -->
        <p><strong>Modello:</strong> <?= $utente['modello'] ?></p>  <!-- mostra il modello della macchina -->
        <p><strong>Marca:</strong> <?= $utente['marca'] ?></p>  <!-- mostra la marca della macchina -->
        <p><strong>Anno:</strong> <?= $utente['anno'] ?></p>  <!-- mostra l'anno della macchina -->
        <p><strong>Posti:</strong> <?= $utente['posti'] ?></p>  <!-- mostra il numero di posti della macchina -->
    <?php endif; ?>

    <!-- Valutazioni ricevute -->
    <h2>Valutazioni Ricevute</h2>
    <?php if ($result_valutazioni->num_rows > 0): ?>  <!-- verifica se ci sono valutazioni -->
        <table border="1">
            <tr>
                <th>Voto</th>  <!-- titolo della colonna voto -->
                <th>Descrizione</th>  <!-- titolo della colonna descrizione -->
                <th>Valutato da</th>  <!-- titolo della colonna valutato da -->
            </tr>
            <?php while ($row = $result_valutazioni->fetch_assoc()): ?>  <!-- ciclo per ogni valutazione ricevuta -->
                <tr>
                    <td><?= $row['voto'] ?></td>  <!-- mostra il voto -->
                    <td><?= $row['descrizione'] ?></td>  <!-- mostra la descrizione della valutazione -->
                    <td><?= $row['nome'] ?> <?= $row['cognome'] ?></td>  <!-- mostra il nome e cognome dell'utente che ha effettuato la valutazione -->
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nessuna valutazione ricevuta.</p>  <!-- messaggio se non ci sono valutazioni -->
    <?php endif; ?>

    <!-- Link per tornare alla dashboard -->
    <br>
    <a href="<?= isset($_SESSION['id_autista']) ? 'dashboard_autista.php' : 'dashboard_passeggero.php' ?>">Torna alla Dashboard</a>  <!-- link per tornare alla dashboard dell'autista o del passeggero -->
</body>
</html>
