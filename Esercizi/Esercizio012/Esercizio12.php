<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "gestioneauto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$tableContent = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'show_assicurazione') {
        $sql = "SELECT * FROM assicurazione";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $tableContent = "<table border='1'>
                                <tr>
                                    <th>ID Assicurazione</th>
                                    <th>Nome Compagnia</th>
                                    <th>Numero Polizza</th>
                                    <th>Data Inizio</th>
                                    <th>Data Fine</th>
                                    <th>Targa Auto</th>
                                </tr>";
            while($row = $result->fetch_assoc()) {
                $tableContent .= "<tr>
                                    <td>".$row['id_assicurazione']."</td>
                                    <td>".$row['nome_compagnia']."</td>
                                    <td>".$row['numero_polizza']."</td>
                                    <td>".$row['data_inizio']."</td>
                                    <td>".$row['data_fine']."</td>
                                    <td>".$row['targa_auto']."</td>
                                  </tr>";
            }
            $tableContent .= "</table>";
        } else {
            $tableContent = "Nessun risultato trovato";
        }
    }
    
    if ($action == 'show_auto') {
        $sql = "SELECT * FROM auto";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $tableContent = "<table border='1'>
                                <tr>
                                    <th>Targa</th>
                                    <th>Marca</th>
                                    <th>Modello</th>
                                    <th>Anno Immatricolazione</th>
                                    <th>Colore</th>
                                    <th>ID Proprietario</th>
                                </tr>";
            while($row = $result->fetch_assoc()) {
                $tableContent .= "<tr>
                                    <td>".$row['targa']."</td>
                                    <td>".$row['marca']."</td>
                                    <td>".$row['modello']."</td>
                                    <td>".$row['anno_immatricolazione']."</td>
                                    <td>".$row['colore']."</td>
                                    <td>".$row['id_proprietario']."</td>
                                  </tr>";
            }
            $tableContent .= "</table>";
        } else {
            $tableContent = "Nessun risultato trovato";
        }
    }

    if ($action == 'show_proprietario') {
        $sql = "SELECT * FROM proprietario";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $tableContent = "<table border='1'>
                                <tr>
                                    <th>ID Proprietario</th>
                                    <th>Nome</th>
                                    <th>Cognome</th>
                                    <th>Codice Fiscale</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Indirizzo</th>
                                </tr>";
            while($row = $result->fetch_assoc()) {
                $tableContent .= "<tr>
                                    <td>".$row['id_proprietario']."</td>
                                    <td>".$row['nome']."</td>
                                    <td>".$row['cognome']."</td>
                                    <td>".$row['codice_fiscale']."</td>
                                    <td>".$row['telefono']."</td>
                                    <td>".$row['email']."</td>
                                    <td>".$row['indirizzo']."</td>
                                  </tr>";
            }
            $tableContent .= "</table>";
        } else {
            $tableContent = "Nessun risultato trovato";
        }
    }

    if ($action == 'show_join') {
        $sql = "SELECT a.id_assicurazione, a.nome_compagnia, a.numero_polizza, a.data_inizio, a.data_fine, 
                       au.targa, au.marca, au.modello, au.anno_immatricolazione, au.colore, 
                       p.nome, p.cognome, p.codice_fiscale
                FROM assicurazione a
                JOIN auto au ON a.targa_auto = au.targa
                JOIN proprietario p ON au.id_proprietario = p.id_proprietario";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $tableContent = "<table border='1'>
                                <tr>
                                    <th>ID Assicurazione</th>
                                    <th>Nome Compagnia</th>
                                    <th>Numero Polizza</th>
                                    <th>Data Inizio</th>
                                    <th>Data Fine</th>
                                    <th>Targa Auto</th>
                                    <th>Marca</th>
                                    <th>Modello</th>
                                    <th>Anno Immatricolazione</th>
                                    <th>Colore</th>
                                    <th>Nome Proprietario</th>
                                    <th>Cognome Proprietario</th>
                                    <th>Codice Fiscale Proprietario</th>
                                </tr>";
            while($row = $result->fetch_assoc()) {
                $tableContent .= "<tr>
                                    <td>".$row['id_assicurazione']."</td>
                                    <td>".$row['nome_compagnia']."</td>
                                    <td>".$row['numero_polizza']."</td>
                                    <td>".$row['data_inizio']."</td>
                                    <td>".$row['data_fine']."</td>
                                    <td>".$row['targa']."</td>
                                    <td>".$row['marca']."</td>
                                    <td>".$row['modello']."</td>
                                    <td>".$row['anno_immatricolazione']."</td>
                                    <td>".$row['colore']."</td>
                                    <td>".$row['nome']."</td>
                                    <td>".$row['cognome']."</td>
                                    <td>".$row['codice_fiscale']."</td>
                                  </tr>";
            }
            $tableContent .= "</table>";
        } else {
            $tableContent = "Nessun risultato trovato";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Auto</title>
</head>
<body>

<h1>Gestione Auto - Sistema Assicurazioni</h1>
<p>Benvenuto nel sistema di gestione delle auto e assicurazioni. Qui puoi visualizzare le informazioni relative alle assicurazioni, alle auto e ai proprietari.</p>

<form method="POST">
    <button type="submit" name="action" value="show_assicurazione">Mostra Assicurazione</button>
    <button type="submit" name="action" value="show_auto">Mostra Auto</button>
    <button type="submit" name="action" value="show_proprietario">Mostra Proprietario</button>
    <button type="submit" name="action" value="show_join">Mostra Tabella Join</button>
</form>
<br><br>

<div>
    <?php
    echo $tableContent;
    ?>
</div>
<br>
<a href="inserisci.php">inserisci dati</a>
<br>
<a href="..\..\index.html">torna all'indice</a>
</body>
</html>

<?php
$conn->close();
?>
