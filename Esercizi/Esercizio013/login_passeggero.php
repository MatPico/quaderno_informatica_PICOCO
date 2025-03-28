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
    die("Connessione fallita: " . $conn->connect_error); // Termina l'esecuzione in caso di errore
}

// Recupera i dati inviati dal form
$mail = $_POST['mail_passeggero'];
$password = $_POST['password_passeggero'];

// Prepara la query per evitare SQL injection
$sql = "SELECT * FROM passeggero WHERE mail=?";
$stmt = $conn->prepare($sql);

// Associa il parametro alla query preparata
$stmt->bind_param("s", $mail);

// Esegui la query
$stmt->execute();

// Ottieni il risultato
$result = $stmt->get_result();

// Verifica se esiste un utente con la mail fornita
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Ottiene i dati del passeggero

    // Verifica se la password inserita corrisponde a quella salvata nel database
    if (password_verify($password, $row['password'])) {
        // Salva l'ID del passeggero nella sessione
        $_SESSION['id_passeggero'] = $row['id_passeggero'];
        
        // Reindirizza alla dashboard del passeggero
        header("Location: dashboard_passeggero.php");
        exit(); // Assicurati che lo script termini dopo il reindirizzamento
    } else {
        echo "Password errata"; // Messaggio di errore in caso di password errata
    }
} else {
    echo "Nessun utente trovato con questa mail"; // Messaggio di errore se la mail non esiste
}

// Chiude la connessione al database
$stmt->close();
$conn->close();
?>
