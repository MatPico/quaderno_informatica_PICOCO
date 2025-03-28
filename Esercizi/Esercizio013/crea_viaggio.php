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
    <title>Crea Viaggio</title>
</head>
<body>
    <h1>Crea Viaggio</h1>
    <!-- crea un modulo per la creazione di un nuovo viaggio -->
    <form action="salva_viaggio.php" method="post">
        <!-- campo per inserire la città di partenza, obbligatorio -->
        <label for="citta_partenza">Città di Partenza:</label>
        <input type="text" id="citta_partenza" name="citta_partenza" required><br>
        
        <!-- campo per inserire la città di arrivo, obbligatorio -->
        <label for="citta_arrivo">Città di Arrivo:</label>
        <input type="text" id="citta_arrivo" name="citta_arrivo" required><br>
        
        <!-- campo per inserire l'ora di partenza, obbligatorio -->
        <label for="ora_partenza">Ora di Partenza:</label>
        <input type="datetime-local" id="ora_partenza" name="ora_partenza" required><br>
        
        <!-- campo per inserire l'ora di arrivo, obbligatorio -->
        <label for="ora_arrivo">Ora di Arrivo:</label>
        <input type="datetime-local" id="ora_arrivo" name="ora_arrivo" required><br>
        
        <!-- campo per inserire il tempo stimato, obbligatorio -->
        <label for="tempo_stimato">Tempo Stimato:</label>
        <input type="time" id="tempo_stimato" name="tempo_stimato" required><br>
        
        <!-- campo per inserire il contributo economico, obbligatorio -->
        <label for="contributo_economico">Contributo Economico:</label>
        <input type="number" id="contributo_economico" name="contributo_economico" step="0.01" required><br>
        
        <!-- campo per inserire il numero di posti disponibili, obbligatorio -->
        <label for="max_posti">Posti Disponibili:</label>
        <input type="number" id="max_posti" name="max_posti" required><br>
        
        <!-- bottone per inviare il modulo e creare il viaggio -->
        <button type="submit">Crea Viaggio</button>
    </form>
    <br>
    <!-- fornisce un link per tornare alla dashboard, in base al tipo di utente (autista o passeggero) -->
    <a href="<?= isset($_SESSION['id_autista']) ? 'dashboard_autista.php' : (isset($_SESSION['id_passeggero']) ? 'dashboard_passeggero.php' : 'index.html') ?>">Torna alla Dashboard</a>
</body>
</html>
