<?php
// riprende o crea una sessione avvenuta sul browser dell'utente
session_start();

// Se la sessione viene avviata senza aver mai ricevuto un user dal form allora crea in automatico admin (al primo avvio viene sempre creato)
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        'admin' => [
            'password' => 'admin',     // Password predefinita
            'nome' => 'Admin',         // NomeUtente predefinito
        ]
    ];
}
// Recupera l'azione inviata dal form tramite il campo nascosto 'action' e 'value'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'register') {
        
        $username = $_POST['username'];     
        $password = $_POST['password'];     
        $email = $_POST['email'];              

        // Controlla se il nome utente scelto esiste già nella sessione
        // Con i valori viene usata una sintassi molto simile ad altri linguaggi (tipo user.username)
        if (isset($_SESSION['users'][$username])) {
            // Se il nome utente esiste, mostra un errore
            echo "Errore: il nome utente '$username' è già registrato.<br>";
        } else {
            // Se il nome utente non esiste, registra il nuovo utente
            // Così si registrerà su una cella della variabile di sessione user un oggetto di nome $username con attributi i restanti valori 
            $_SESSION['users'][$username] = [
                'password' => $password,   
                'email' => $email,         
            ];
            echo "Registrazione completata con successo! Puoi accedere ora.<br>";
        }
    } elseif ($action === 'login') {
        // L'utente ha scelto di accedere
        // Recupera i dati inviati dal form di login
        $username = $_POST['username'];     
        $password = $_POST['password'];     

        // Confrontiamo con i vari utenti salvati sulla sessione e controlliamo che i dati concidano
        if (isset($_SESSION['users'][$username]) && $_SESSION['users'][$username]['password'] === $password) {
            // Se il nome utente e la password sono corretti
            echo "Benvenuto! Accesso effettuato con successo.<br>";
        } else {
            // Se nome utente o password sono sbagliati
            echo "Errore: nome utente o password non corretti.<br>";
        }
    } else {
        // Caso in cui l'azione inviata non sia valida (es. nessun valore in 'action')
        echo "Azione non valida.<br>";
    }
}
echo '<br><a href="Esercizio10.html">Torna alla pagina iniziale</a>';
?>