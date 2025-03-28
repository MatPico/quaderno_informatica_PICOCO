<?php
// avvia la sessione per gestire le variabili di sessione
session_start();

// verifica se la variabile di sessione 'id_passeggero' è impostata; se non lo è, redirige alla pagina index.html
if (!isset($_SESSION['id_passeggero'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Passeggero</title>
</head>
<body>
    <h1>Dashboard Passeggero</h1>
    
    <!-- crea un bottone per accedere alla pagina di ricerca dei viaggi -->
    <button onclick="location.href='cerca_viaggi.php'">Cerca Viaggi</button>
    
    <!-- crea un bottone per accedere alla gestione delle prenotazioni -->
    <button onclick="location.href='gestione_prenotazioni.php'">Gestione Prenotazioni</button>
    
    <!-- crea un bottone per visualizzare il profilo del passeggero -->
    <button onclick="location.href='profilo.php?id=<?= $_SESSION['id_passeggero'] ?>&ruolo=passeggero'">Profilo</button>
    
    <!-- crea un bottone per effettuare il logout e terminare la sessione -->
    <button onclick="location.href='logout.php'">Logout</button>
</body>
</html>
