<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Creo una matrice per tutti gli errori
    $errors = [];

    // Pulizia input da spazi bianchi
    $nome = trim(htmlspecialchars($_POST["nome"]));
    $cognome = trim(htmlspecialchars($_POST["cognome"]));
    $nickname = trim(htmlspecialchars($_POST["nickname"]));
    $email = trim($_POST["email"]);

    // Validazione Nome = se nome è vuoto inserisce l'errore
    if (empty($nome)) {
        $errors[] = "Il nome è obbligatorio.";
    }

    // Validazione Cognome = se cognome è vuoto inserisce l'errore
    if (empty($cognome)) {
        $errors[] = "Il cognome è obbligatorio.";
    }

    // Validazione Nickname = controlla se è vuoto o identico a nome/cognome restituisce errori 
    if (empty($nickname)) {
        $errors[] = "Il nickname è obbligatorio.";
    } elseif ($nickname === $nome || $nickname === $cognome) {
        $errors[] = "Il nickname deve essere diverso da nome e cognome.";
    }

    // Validazione Email = verifica se la mail è presente e valida
    if (empty($email)) {
        $errors[] = "L'email è obbligatoria.";
        // per valide email si intende una mail con sistassi "testo@dominio.xxx.xx" il resto da errore
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email non è valida.";
    }

    // Se ci sono errori, quindi errors[] non è vuoto, stampa ogni stringa inserita in errors
    if (!empty($errors)) {
        echo "<div style='color:red'>";
        echo "<h2>Si sono verificati i seguenti errori:</h2>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "<p><a href='Esercizio9.html'>Torna indietro</a></p>";
        echo "</div>";
    } else {
        // se è corretta stampa i dati
        echo "<h1>Dati Inseriti:</h1>";
        echo "<p>Nome: $nome</p>";
        echo "<p>Cognome: $cognome</p>";
        echo "<p>Nickname: $nickname</p>";
        echo "<p>Email: $email</p>";
        echo "<!-- link per tornare a index.html -->
                <a href='Esercizio9.html'>torna al modulo</a>";
    }
}
?>
