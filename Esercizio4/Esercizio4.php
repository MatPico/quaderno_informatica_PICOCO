<!DOCTYPE html>
<head>
    <!-- implemento nello style il tipo di font-family come chiesto dal compito -->
    <style>
        body {
            font-family: monospace;
        }
    </style>
    <title>Triangoli PHP</title>
</head>
<body>
    <h1>Triangoli PHP</h1>
    <!-- link per tornare a index.html -->
    <a href="..\index.html">torna all'indice</a>
    <?php

    /*
    la consegna chiedeva di stampare ogni volta un asterisco singolarmente
    questo avrebbe portato il codice a fare tantissimi giri di for e creare condizioni
    uso il metodo str_repeat(), ovvero string repeat, che chiede un parametro stringa e un numero di volte da moltiplicare
    il parametro viene comunque realmente stampato uno alla volta, ma l'azione viene ripetuta più volte come richiesto
    in questo caso userò il for per contare le righe, righe a cui tornerò a capo con br
    e i metodi str_repeat stamperanno spazi e asterischi in maniera inversa man mano che il for aumenta
    */

    // Triangolo (a)
    echo "<h3>Triangolo (a)</h3>";
    for ($i = 1; $i <= 10; $i++) {
        echo str_repeat("*", $i);
        echo "<br>";
    }
    echo "<br>";
    // Triangolo (b)
    echo "<h3>Triangolo (b)</h3>";
    for ($i = 10; $i >= 1; $i--) {
        echo str_repeat("*", $i);
        echo "<br>";
    }
    echo "<br>";
    // Triangolo (c)
    echo "<h3>Triangolo (c)</h3>";
    for ($i = 10; $i >= 1; $i--) {
        echo str_repeat("&nbsp;", 10 - $i);
        echo str_repeat("*", $i);
        echo "<br>";
    }
    echo "<br>";
    // Triangolo (d)
    echo "<h3>Triangolo (d)</h3>";
    for ($i = 1; $i <= 10; $i++) {
        echo str_repeat("&nbsp;", 10 - $i);
        echo str_repeat("*", $i);
        echo "<br>";
    }
    ?>
    <br>
    <!-- link per tornare a index.html -->
    <a href="..\index.html">torna all'indice</a>
</body>
</html>
