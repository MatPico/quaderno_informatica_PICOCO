<?php
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

// Recupera i dati inviati dal form tramite POST
$nome = $_POST['nome_passeggero'];  // recupera il nome del passeggero
$cognome = $_POST['cognome_passeggero'];  // recupera il cognome del passeggero
$numero = $_POST['numero_passeggero'];  // recupera il numero di telefono del passeggero
$numero_carta_identita = $_POST['numero_carta_identita'];  // recupera il numero della carta d'identità
$mail = $_POST['mail_passeggero'];  // recupera l'email del passeggero
$password = password_hash($_POST['password_passeggero'], PASSWORD_DEFAULT);  // recupera e cripta la password del passeggero

// Inserisce i dati del passeggero nel database
$sql = "INSERT INTO passeggero (nome, cognome, numero, numero_carta_identita, mail, password, ruolo) 
        VALUES ('$nome', '$cognome', '$numero', '$numero_carta_identita', '$mail', '$password', 'passeggero')";

// verifica se la query per inserire il passeggero è stata eseguita con successo
if ($conn->query($sql)) {
    echo "Registrazione completata con successo!";  // messaggio di successo se il passeggero è stato registrato correttamente
} else {
    echo "Errore: " . $sql . "<br>" . $conn->error;  // messaggio di errore se la query non è riuscita
}

$conn->close();  // chiude la connessione al database
?>
<br>
<a href="index.html">torna al login</a>  <!-- link per tornare alla pagina di login -->
