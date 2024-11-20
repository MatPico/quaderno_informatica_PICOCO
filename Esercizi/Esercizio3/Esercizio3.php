
<?php
// Creo la variabile nome e le do valore Paolo come stringa
$nome = "Paolo";
// Ottiene l'ora corrente nel fuso orario del server
date_default_timezone_set("Europe/Rome"); // Imposta il fuso orario
$oraCorrente = date("H");  // Ottiene l'ora attuale (formato 24 ore)
$minutiCorrenti = date("i"); // Ottiene i minuti correnti

// Determina il messaggio in base all'ora e ai minuti
if ($oraCorrente == 16 && $minutiCorrenti == 30) {
    $messaggio = "È l'ora del tè!";
} elseif ($oraCorrente >= 8 && $oraCorrente < 12) {
    $messaggio = "Buongiorno";
} elseif ($oraCorrente >= 12 && $oraCorrente < 20) {
    $messaggio = "Buonasera";
} else {
    $messaggio = "Buonanotte";
}

// La variabile browser prende il valore della variabile predefinita Server che contiene il browser usato dall'utente
$browser = $_SERVER['HTTP_USER_AGENT'];
?>

<!DOCTYPE html>
<head>
    <!-- uso comando meta per refreshare la pagina ogni 1sec mi permette di avere un orologio dinamico senza usare script
            e mi da un intervallo di tempo abbastanza largo per non interferire con il click dell'utente -->
    <meta http-equiv="refresh" content="1">
    <title>Saluto in base all'ora</title>
</head>
<body>
    <!-- dentro h3 mostro con il messaggio, poi il nome e alla fine un testo predefinito -->
    <h3><?php echo "$messaggio $nome, benvenuto nella mia prima pagina PHP!"; ?></h3>
    <!-- mostro la l'orario usando il formato completo del metodo date() -->
    <p>Ora corrente: <?php echo date("H:i:s"); ?></p>
    <!-- mostro in quale browser l'utente è collegato -->
    <p>Stai usando il browser: <?php echo $browser; ?></p>
    <!-- link per tornare a index.html -->
    <a href="..\..\index.html">torna all'indice</a>
</body>
</html>
