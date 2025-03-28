<?php
session_start(); // Avvia la sessione per mantenere i dati dell'utente loggato

// Dati per la connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpooling";

// Connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se la connessione ha avuto successo
if ($conn->connect_error) {
    die("connessione fallita: " . $conn->connect_error); // Termina l'esecuzione in caso di errore
}

// Recupera i dati inviati dal form
$mail = $_POST['mail_autista'];
$password = $_POST['password_autista'];

// Query per selezionare l'autista con la mail specificata
$sql = "SELECT * FROM autista WHERE mail='$mail'";
$result = $conn->query($sql);

// Verifica se esiste un utente con la mail fornita
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Ottiene i dati dell'autista

    // Verifica se la password inserita corrisponde a quella salvata nel database
    if (password_verify($password, $row['password'])) {
        // Salva l'ID dell'autista nella sessione
        $_SESSION['id_autista'] = $row['id_autista'];
        
        // Reindirizza alla dashboard dell'autista
        header("Location: dashboard_autista.php");
        exit();
    } else {
        echo "password errata"; // Messaggio di errore in caso di password errata
    }
} else {
    echo "nessun utente trovato con questa mail"; // Messaggio di errore se la mail non esiste
}

// Chiude la connessione al database
$conn->close();
?>
