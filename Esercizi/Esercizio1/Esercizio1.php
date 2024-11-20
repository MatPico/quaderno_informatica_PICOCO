<?php
session_start();

/* 
Utilizzo !isset per controllare che non sia stata già inizializzata
se sessione stato non sarà inizializzato allora la imposterò a spento
*/
if (!isset($_SESSION['stato'])) {
    $_SESSION['stato'] = 'spento';
}

/*
quando ricevo un post di premi allora controllo se la variabile sessione di stato è spenta
se true allora diventa "acceso"
se false rimane "spento"
*/
if (isset($_POST['premi'])) {
    $_SESSION['stato'] = ($_SESSION['stato'] === 'spento') ? 'acceso' : 'spento';
}

// Salva lo stato sulla variabile che viene mostrata all'utente
$statoAttuale = $_SESSION['stato'];
?>

<!DOCTYPE html>
<head>
    <title>Interruttore Acceso/Spento</title>
</head>
<body>
    <!-- mostra lo stato attuale, ho visto che più avanti dovrei usare "htmlspecialchars()" perchè (non in questo caso),
        se fosse un testo deciso dall'utente in un field e poi elaborato, l'utente potrebbe inserire codici in html nel field infastidendo il codice
    -->
    <h1>Stato: <?php echo $statoAttuale; ?></h1>
    
    <!-- forma che usa un pulsante di invio che invi una variabile di metodo post e modifiche il comando nel pulsante-->
    <form method="post">
        <button type="submit" name="premi">
            <?php echo ($statoAttuale === 'spento') ? 'Accendi' : 'Spegni'; ?>
        </button>
    </form>
    
    <!-- link per tornare a index.html -->
    <a href="..\..\index.html">torna all'indice</a>
</body>
</html>