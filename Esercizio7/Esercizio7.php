<!DOCTYPE html>
<head>
    <title>Tabella Quadrati e Cubi</title>
    <style>
        table {
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php
// Inizializziamo la variabile $n a 0 per garantire che non ci siano conflitti
$n = 0;

// Controllo se il server sta ricevendo azioni con metodo POST 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se è stato premuto il pulsante "Crea tabella"
    if (isset($_POST['crea_tabella'])) {
        // Controllo se il numero è inizializzato e lo assegno a $n
        $n = isset($_POST['numero']) ? (int)$_POST['numero'] : 0;

        // Controlla che il numero sia compreso tra 1 e 10
        if ($n >= 1 && $n <= 10) {
            echo "<h2>Tabella dei quadrati e dei cubi da 1 a $n</h2>";
            echo "<table>";
            echo "<tr><th>Numero</th><th>Quadrato</th><th>Cubo</th></tr>";
            // Calcoli per quadrato e cubo e stampo le righe della tabella
            for ($i = 1; $i <= $n; $i++) {
                $quadrato = $i ** 2;
                $cubo = $i ** 3;
                echo "<tr><td>$i</td><td>$quadrato</td><td>$cubo</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Errore: il numero deve essere compreso tra 1 e 10.</p>";
        }

        // Aggiunge un pulsante per rimuovere la tabella
        echo "<br>
              <form method='post'>
                <button type='submit' name='rimuovi_tabella'>Rimuovi tabella</button>
              </form>";
    } elseif (isset($_POST['rimuovi_tabella'])) {
        // Rimuove la tabella e mostra il form con il numero selezionato
        echo "<p>La tabella è stata rimossa.</p>";
    }
} 

// Mostra il form per l'inserimento del numero
?>
<h2>Inserisci un numero tra 1 e 10</h2>
<form method="post">
    <!-- selettore di dati, con il valore pre-selezionato che viene mantenuto -->
    <label for="numero">Numero:</label>
    <select name="numero" id="numero">
        <?php
        // Ciclo per creare le opzioni del select, mantenendo il valore selezionato
        for ($i = 1; $i <= 10; $i++) {
            // Se il numero è uguale al valore di $n, lo selezioniamo
            $selected = ($i == $n) ? 'selected' : '';
            echo "<option value=\"$i\" $selected>$i</option>";
        }
        ?>
    </select>
    <button type="submit" name="crea_tabella">Crea tabella</button>
</form>
<br>
<!-- link per tornare a index.html -->
<a href='..\index.html'>torna all'indice</a>
</body>
</html>
