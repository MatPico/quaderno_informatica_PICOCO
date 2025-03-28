<?php
// avvia la sessione per gestire le variabili di sessione
session_start();

// verifica se la variabile di sessione 'id_autista' è impostata; se non lo è, redirige alla pagina index.html
if (!isset($_SESSION['id_autista'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Autista</title>
</head>
<body>
    <h1>Dashboard Autista</h1>
    <!-- crea un bottone per andare alla pagina di creazione viaggio -->
    <button onclick="location.href='crea_viaggio.php'">Crea Viaggio</button>
    
    <!-- crea un bottone per andare alla lista dei viaggi -->
    <button onclick="location.href='lista_viaggi.php'">Lista Viaggi</button>
    
    <!-- crea un bottone per modificare i dettagli della macchina -->
    <button onclick="location.href='modifica_macchina.php'">Modifica Macchina</button>
    
    <!-- crea un bottone per visualizzare il profilo dell'autista -->
    <button onclick="location.href='profilo.php?id=<?= $_SESSION['id_autista'] ?>&ruolo=autista'">Profilo</button>
    
    <!-- crea un bottone per fare il logout e uscire dalla sessione -->
    <button onclick="location.href='logout.php'">Logout</button>
</body>
</html>
