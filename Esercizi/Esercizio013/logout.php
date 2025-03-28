<?php
// Avvia la sessione per poter gestire i dati dell'utente
session_start();

// Distrugge la sessione, rimuovendo tutte le variabili di sessione
session_destroy();

// Reindirizza l'utente alla pagina di login (index.html)
header("Location: index.html");

// Termina l'esecuzione dello script dopo il reindirizzamento
exit();
?>