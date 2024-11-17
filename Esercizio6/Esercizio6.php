<?php
// Simuliamo delle credenziali valide per l'autenticazione
$valid_username = "admin";
$valid_password = "admin";

// Funzione per visualizzare il form di login, display_form richiede un dato che viene impostato in default ''
function display_form($error_message = '') {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <h1>Login</h1>";
        
    //se il metodo riceve il dato viene considerato pieno e quindi true, per poi essere mostrato
    if ($error_message) {
        echo "<p>$error_message</p>";
    }
    // Stampa del form
    echo "<form method='post' action=''>
            <label for='username'>Username:</label>
            <input type='text' id='username' name='username' required><br><br>
            
            <label for='password'>Password:</label>
            <input type='password' id='password' name='password' required><br><br>
            
            <button type='submit' name='submit'>Login</button>
        </form>
        <br>
        <!-- link per tornare a index.html -->
        <a href='..\index.html'>torna all'indice</a>
    </body>
    </html>";
}

// Controllo se il server ha ricevuto delle richieste di post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Controlliamo se il form è stato inviato controllando se il post di submit e inizializzato
    if (isset($_POST['submit'])) {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Validazione delle credenziali controlla se i dati inseriti siano corretti per quelli che il codice si aspetta
        if ($username === $valid_username && $password === $valid_password) {
            echo "<!DOCTYPE html>
            <html>
            <head>
                <title>Benvenuto</title>
            </head>
            <body>
                <h1>Benvenuto, $username!</h1>
                <p>Login effettuato con successo.</p>
                <!-- link per tornare a index.html -->
                <a href='..\index.html'>torna all'indice</a>
            </body>
            </html>";
        } else {
            // Messaggio di errore e riproposizione del form
            display_form("Credenziali errate. Riprova.");
        }
    } else {
        // Se il form non è stato inviato correttamente, mostra il form
        display_form();
    }
} else {
    // Se non è stato fatto un POST, visualizziamo il form di login
    display_form();
    
}
?>
