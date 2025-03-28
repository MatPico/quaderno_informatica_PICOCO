<?php
session_start();  // avvia la sessione per poter usare le variabili di sessione

// verifica se l'utente è loggato come autista
if (!isset($_SESSION['id_autista'])) {
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

$id_autista = $_SESSION['id_autista'];  // recupera l'id dell'autista dalla sessione

// ottiene i dati attuali della macchina associata all'autista
$sql_macchina = "SELECT m.* 
                 FROM Macchina m 
                 JOIN autista a ON m.id_macchina = a.id_macchina 
                 WHERE a.id_autista='$id_autista'";  // query SQL per recuperare i dati della macchina
$result_macchina = $conn->query($sql_macchina);  // esegue la query
$macchina = $result_macchina->fetch_assoc();  // recupera i risultati in formato associativo

// gestione del form di modifica
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // verifica se il metodo di richiesta è POST
    $colore = $_POST['colore'];  // recupera il colore inviato dal form
    $modello = $_POST['modello'];  // recupera il modello inviato dal form
    $marca = $_POST['marca'];  // recupera la marca inviata dal form
    $anno = $_POST['anno'];  // recupera l'anno inviato dal form
    $posti = $_POST['posti'];  // recupera il numero di posti inviato dal form

    // query SQL per aggiornare i dati della macchina
    $sql_update = "UPDATE Macchina 
                   SET colore='$colore', modello='$modello', marca='$marca', anno='$anno', posti='$posti' 
                   WHERE id_macchina='{$macchina['id_macchina']}'";  // aggiornamento della macchina

    if ($conn->query($sql_update)) {  // esegue la query di aggiornamento
        $messaggio = "Dati della macchina aggiornati con successo!";  // messaggio di successo
        // ricarica i dati della macchina
        $result_macchina = $conn->query($sql_macchina);  // esegue nuovamente la query
        $macchina = $result_macchina->fetch_assoc();  // recupera i dati aggiornati
    } else {
        $errore = "Errore durante l'aggiornamento: " . $conn->error;  // messaggio di errore in caso di fallimento
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Modifica Macchina</title>
</head>
<body>
    <h1>Modifica Dati della Macchina</h1>
    <?php if (isset($messaggio)) echo "<p style='color:green;'>$messaggio</p>"; ?>  <!-- messaggio di successo -->
    <?php if (isset($errore)) echo "<p style='color:red;'>$errore</p>"; ?>  <!-- messaggio di errore -->

    <!-- form per modificare i dati della macchina -->
    <form method="post">
        <label for="colore">Colore:</label>
        <input type="text" id="colore" name="colore" value="<?= $macchina['colore'] ?>" required><br>  <!-- campo colore -->

        <label for="modello">Modello:</label>
        <input type="text" id="modello" name="modello" value="<?= $macchina['modello'] ?>" required><br>  <!-- campo modello -->

        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" value="<?= $macchina['marca'] ?>" required><br>  <!-- campo marca -->

        <label for="anno">Anno:</label>
        <input type="text" id="anno" name="anno" value="<?= $macchina['anno'] ?>" required><br>  <!-- campo anno -->

        <label for="posti">Posti:</label>
        <input type="number" id="posti" name="posti" value="<?= $macchina['posti'] ?>" required><br>  <!-- campo posti -->

        <button type="submit">Salva Modifiche</button>  <!-- bottone per inviare il form -->
    </form>

    <br>
    <!-- link per tornare alla dashboard dell'autista -->
    <a href="dashboard_autista.php">Torna alla Dashboard</a>
</body>
</html>
