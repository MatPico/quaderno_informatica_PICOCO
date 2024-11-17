<?php
// riprende o crea una sessione avvenuta sul browser dell'utente
session_start();

// Se la sessione viene avviata senza aver mai ricevuto un user dal form allora crea in automatico admin (al primo avvio viene sempre creato)
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        'admin' => [
            'password' => 'admin',     // Password predefinita
            'nome' => 'Admin',         // Nome del profilo
        ]
    ];
}

// Recupera l'azione inviata dal form tramite il campo nascosto 'action' e 'value'
$action = $_POST['action'];

if ($action === 'register') {
    // Se l'azione inviata ha come value la registrazione
    // Recupera i dati inviati dal form di registrazione
    $nome = $_POST['nome'];             // Nome dell'utente
    $cognome = $_POST['cognome'];       // Cognome dell'utente
    $username = $_POST['username'];     // Nome utente scelto
    $password = $_POST['password'];     // Password scelta
    $email = $_POST['email'];           // Email dell'utente
    $sesso = $_POST['sesso'];           // Sesso dell'utente

    // Controlla se il nome utente scelto esiste già nella sessione
    // Con i valori viene usata una sintassi molto simile ad altri linguaggi (tipo user.username)
    if (isset($_SESSION['users'][$username])) {
        // Se il nome utente esiste, mostra un errore
        echo "Errore: il nome utente '$username' è già registrato.<br>";
    } else {
        // Se il nome utente non esiste, registra il nuovo utente
        // Così si registrerà su una cella della variabile di sessione user un oggetto di nome $username con attributi i restanti valori 
        $_SESSION['users'][$username] = [
            'password' => $password,   // Salva la password
            'nome' => $nome,           // Salva il nome
            'cognome' => $cognome,     // Salva il cognome
            'email' => $email,         // Salva l'email
            'sesso' => $sesso,         // Salva il sesso
        ];
        // Conferma all'utente che la registrazione è avvenuta con successo
        echo "Registrazione completata con successo! Puoi accedere ora.<br>";
    }
} elseif ($action === 'login') {
    // L'utente ha scelto di accedere
    // Recupera i dati inviati dal form di login
    $username = $_POST['username'];     // Nome utente fornito
    $password = $_POST['password'];     // Password fornita

    /* 
        Controlla se il nome utente esiste e se la password corrisponde
        Stringa logicalmente complessa che è paragonabile a:
        Se nella variabile di sessione[utente] esiste un $username appena preso dal post di accesso
        e se
        nella variabile di sessione[utente] l'oggetto ha la password uguale alla password appena inserita
        allora returna true, oppure false.
        
        la sintassi è composta principalmente da parentesi [] 
        ma sarebbe identico alla logica di users.personaRegistrata.passwordPersona quindi Array/Oggetto/Attributo
    */
    if (isset($_SESSION['users'][$username]) && $_SESSION['users'][$username]['password'] === $password) {
        // Se il nome utente e la password sono corretti, mostra un messaggio di benvenuto
        echo "Benvenuto, " . $_SESSION['users'][$username]['nome'] . "! Accesso effettuato con successo.<br>";
    } else {
        // Se nome utente o password sono sbagliati, mostra un messaggio di errore
        echo "Errore: nome utente o password non corretti.<br>";
    }
} else {
    // Caso in cui l'azione inviata non sia valida (es. nessun valore in 'action')
    echo "Azione non valida.<br>";
}

// Mostra un link per tornare alla pagina iniziale (index.php)
echo '<br><a href="Esercizio5.php">Torna alla pagina iniziale</a>';
?>

