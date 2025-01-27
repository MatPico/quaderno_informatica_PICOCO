<?php
// Connessione al database
$conn = new mysqli("localhost", "root", "", "GestioneAuto");
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Gestione inserimento dati Proprietario
if (isset($_POST['submit_proprietario'])) {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $codice_fiscale = $_POST['codice_fiscale'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $indirizzo = $_POST['indirizzo'];

    $sql = "INSERT INTO Proprietario (nome, cognome, codice_fiscale, telefono, email, indirizzo)
            VALUES ('$nome', '$cognome', '$codice_fiscale', '$telefono', '$email', '$indirizzo')";

    if ($conn->query($sql)) {
        echo "Proprietario inserito con successo!<br>";
    } else {
        echo "Errore durante l'inserimento del proprietario: " . $conn->error . "<br>";
    }
}

// Gestione inserimento dati Auto
if (isset($_POST['submit_auto'])) {
    $targa = $_POST['targa'];
    $marca = $_POST['marca'];
    $modello = $_POST['modello'];
    $anno = $_POST['anno'];
    $colore = $_POST['colore'];
    $id_proprietario = $_POST['id_proprietario'];

    // Verifica che il proprietario esista
    $result = $conn->query("SELECT * FROM Proprietario WHERE id_proprietario = '$id_proprietario'");
    if ($result->num_rows == 0) {
        echo "Errore: il proprietario con ID $id_proprietario non esiste.<br>";
    } else {
        $sql = "INSERT INTO Auto (targa, marca, modello, anno_immatricolazione, colore, id_proprietario)
                VALUES ('$targa', '$marca', '$modello', '$anno', '$colore', '$id_proprietario')";

        if ($conn->query($sql)) {
            echo "Auto inserita con successo!<br>";
        } else {
            echo "Errore durante l'inserimento dell'auto: " . $conn->error . "<br>";
        }
    }
}

// Gestione inserimento dati Assicurazione
if (isset($_POST['submit_assicurazione'])) {
    $nome_compagnia = $_POST['nome_compagnia'];
    $numero_polizza = $_POST['numero_polizza'];
    $data_inizio = $_POST['data_inizio'];
    $data_fine = $_POST['data_fine'];
    $targa_auto = $_POST['targa_auto'];

    // Verifica che l'auto esista
    $result = $conn->query("SELECT * FROM Auto WHERE targa = '$targa_auto'");
    if ($result->num_rows == 0) {
        echo "Errore: l'auto con targa $targa_auto non esiste.<br>";
    } else {
        $sql = "INSERT INTO Assicurazione (nome_compagnia, numero_polizza, data_inizio, data_fine, targa_auto)
                VALUES ('$nome_compagnia', '$numero_polizza', '$data_inizio', '$data_fine', '$targa_auto')";

        if ($conn->query($sql)) {
            echo "Assicurazione inserita con successo!<br>";
        } else {
            echo "Errore durante l'inserimento dell'assicurazione: " . $conn->error . "<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserimento Dati</title>
</head>
<body>
    <h1>Inserimento Dati</h1>

    <!-- Form per inserire un nuovo proprietario -->
    <h2>Inserisci Proprietario</h2>
    <form method="POST" action="inserisci.php">
        <label>Nome:</label>
        <input type="text" name="nome" required><br>
        <label>Cognome:</label>
        <input type="text" name="cognome" required><br>
        <label>Codice Fiscale:</label>
        <input type="text" name="codice_fiscale" maxlength="16" required><br>
        <label>Telefono:</label>
        <input type="text" name="telefono"><br>
        <label>Email:</label>
        <input type="email" name="email"><br>
        <label>Indirizzo:</label>
        <input type="text" name="indirizzo"><br>
        <button type="submit" name="submit_proprietario">Inserisci Proprietario</button>
    </form>

    <!-- Form per inserire una nuova auto -->
    <h2>Inserisci Auto</h2>
    <form method="POST" action="inserisci.php">
        <label>Targa:</label>
        <input type="text" name="targa" maxlength="10" required><br>
        <label>Marca:</label>
        <input type="text" name="marca" required><br>
        <label>Modello:</label>
        <input type="text" name="modello" required><br>
        <label>Anno Immatricolazione:</label>
        <input type="number" name="anno" min="1900" max="2100" required><br>
        <label>Colore:</label>
        <input type="text" name="colore"><br>
        <label>ID Proprietario:</label>
        <input type="number" name="id_proprietario" required><br>
        <button type="submit" name="submit_auto">Inserisci Auto</button>
    </form>

    <!-- Form per inserire un'assicurazione -->
    <h2>Inserisci Assicurazione</h2>
    <form method="POST" action="inserisci.php">
        <label>Nome Compagnia:</label>
        <input type="text" name="nome_compagnia" required><br>
        <label>Numero Polizza:</label>
        <input type="text" name="numero_polizza" required><br>
        <label>Data Inizio:</label>
        <input type="date" name="data_inizio" required><br>
        <label>Data Fine:</label>
        <input type="date" name="data_fine" required><br>
        <label>Targa Auto:</label>
        <input type="text" name="targa_auto" maxlength="10" required><br>
        <button type="submit" name="submit_assicurazione">Inserisci Assicurazione</button>
    </form>

    <br>
    <a href="Esercizio12.php">Torna alla Visualizzazione</a>
    <br>
    <a href="..\..\index.html">torna all'indice</a>
</body>
</html>

<?php
$conn->close();
?>
