<?php
// percorso del file
$file = 'Dati.txt';

/*
    funzione che controlla l'esistenza del percorso
    crea una variabile users dove verrano inseriti gli utenti letti
    crea una variabile lines che prende tutte le righe del file escludendo quele vuote
        per ogni linea di linee dividerà la stringa dove sono presenti i ";" controllando che ci siamo 3 segmenti finali
    creerà col primo valore l'utente all'interno di users, col secondo la mail e la terza la password
*/
function Leggi($file) {
    $users = [];
    if (file_exists($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $data = explode(';', $line); // Divide la riga in campi
            if (count($data) === 3) {
                $users[$data[0]] = [
                    'email' => $data[1],
                    'password' => $data[2],
                ];
            }
        }
    }
    return $users;
}

// dati il percorso file, username, mail e password crea una nuova riga in append (a capo), dove inserisce i dati nella sintassi corretta
function Scrivi($file, $username, $email, $password) {
    $line = "$username;$email;$password\n"; // Crea una nuova riga con i dati
    file_put_contents($file, $line, FILE_APPEND); 
}

// crea users e le fa returnare da leggi tutti gli utenti
$users = Leggi($file);
// controllo quale form sia stato attivato 
$action = $_POST['action'];

if ($action === 'register') {
    // recupera dati dal form
    $username = $_POST['username'];     
    $password = $_POST['password'];     
    $email = $_POST['email'];           

    // controllo se il nome utente scelto esiste già
    if (isset($users[$username])) {
        // se il nome utente esiste, mostro un errore
        echo "Errore: il nome utente '$username' è già registrato.<br>";
    } else {
        // se il nome utente non esiste, registra il nuovo utente
        Scrivi($file, $username, $email, $password);
        echo "Registrazione completata con successo! Puoi accedere ora.<br>";
    }
} elseif ($action === 'login') {
    // recupera i dati inviati dal form di login
    $username = $_POST['username'];     
    $password = $_POST['password'];     

    // controlla se il nome utente esiste e se la password corrisponde
    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        // se il nome e password sono corretti
        echo "Benvenuto, $username! Accesso effettuato con successo.<br>";
    } else {
        // se nome e password sono errati
        echo "Errore: nome utente o password non corretti.<br>";
    }
} else {
    // errore nel caso che action non sia ne registrazione che login
    echo "Azione non valida.<br>";
}

echo '<br><a href="Esercizio11.html">Torna alla pagina iniziale</a>';
?>