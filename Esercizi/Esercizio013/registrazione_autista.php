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
$nome = $_POST['nome_autista'];  // recupera il nome dell'autista
$cognome = $_POST['cognome_autista'];  // recupera il cognome dell'autista
$numero = $_POST['numero_autista'];  // recupera il numero di telefono dell'autista
$numero_patente = $_POST['numero_patente'];  // recupera il numero della patente dell'autista
$scadenza_patente = $_POST['scadenza_patente'];  // recupera la data di scadenza della patente
$mail = $_POST['mail_autista'];  // recupera l'email dell'autista
$password = password_hash($_POST['password_autista'], PASSWORD_DEFAULT);  // recupera e cripta la password dell'autista
$colore_macchina = $_POST['colore_macchina'];  // recupera il colore della macchina
$modello_macchina = $_POST['modello_macchina'];  // recupera il modello della macchina
$marca_macchina = $_POST['marca_macchina'];  // recupera la marca della macchina
$anno_macchina = $_POST['anno_macchina'];  // recupera l'anno della macchina
$posti_macchina = $_POST['posti_macchina'];  // recupera il numero di posti della macchina

// Inserisci i dati della macchina nel database
$sql_macchina = "INSERT INTO Macchina (colore, modello, marca, anno, posti) VALUES ('$colore_macchina', '$modello_macchina', '$marca_macchina', '$anno_macchina', '$posti_macchina')";

// verifica se la query per inserire la macchina è stata eseguita con successo
if ($conn->query($sql_macchina)) {
    $id_macchina = $conn->insert_id;  // recupera l'ID dell'ultima macchina inserita nel database

    // Inserisci i dati dell'autista nel database
    $sql_autista = "INSERT INTO autista (id_macchina, nome, cognome, numero, numero_patente, scadenza_patente, mail, password, ruolo) 
                    VALUES ('$id_macchina', '$nome', '$cognome', '$numero', '$numero_patente', '$scadenza_patente', '$mail', '$password', 'autista')";

    // verifica se la query per inserire l'autista è stata eseguita con successo
    if ($conn->query($sql_autista)) {
        echo "Registrazione completata con successo!";  // messaggio di successo se l'autista è stato registrato correttamente
    } else {
        echo "Errore: " . $sql_autista . "<br>" . $conn->error;  // messaggio di errore se la query per l'autista non è riuscita
    }
} else {
    echo "Errore: " . $sql_macchina . "<br>" . $conn->error;  // messaggio di errore se la query per la macchina non è riuscita
}

$conn->close();  // chiude la connessione al database
?>
<br>
<a href="index.html">torna al login</a>  <!-- link per tornare alla pagina di login -->
