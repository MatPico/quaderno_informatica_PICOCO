
<!DOCTYPE html>
<!-- in questo codice la parte di php è minima e si limita al fare ciclare un for che permetta di stampare la tabella e inserire i dati -->
<head>
    <title>Tabella Pitagorica</title>
</head>
<body>
    <h1>Tabella Pitagorica</h1>
    <table border=1>
        <tr>
            <?php
            // Intestazione della prima riga (1-10)
            // Stampo il valore dell'indice i 
            for ($i = 0; $i <= 10; $i++) {
                echo "<th>$i</th>";
            }
            ?>
        </tr>
        <?php
        // Creazione delle righe della tabella
        // Utilizzo row come indice delle righe
        for ($row = 1; $row <= 10; $row++) {
            // codice in html per aprire una riga
            echo "<tr>";
            // prima casella head che avrà sempre il valore di row
            echo "<th>$row</th>";
            // secondo for con indice col che conta a che colonna sono e la moltiplica per la posizione della riga row
            // se sarò nella quinta colonna nella terza riga darà risultato 15
            for ($col = 1; $col <= 10; $col++) {
                $result = $row * $col;
                //stampo risultato
                echo "<td>$result</td>";
            }
            //chiudo la riga 
            echo "</tr>";
        }
        ?>
    </table>
    <br>
    <!-- link per tornare a index.html -->
    <a href="..\..\index.html">torna all'indice</a>

</body>
</html>
