<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Raccolta dati togliendo i caratteri speciali che potrebbero fare da injector o jailBreaker ( come <> ? ecc)
    $nome = htmlspecialchars($_POST["nome"]);
    $cognome = htmlspecialchars($_POST["cognome"]);
    $data_nascita = htmlspecialchars($_POST["data_nascita"]);
    $codice_fiscale = htmlspecialchars($_POST["codice_fiscale"]);
    $email = htmlspecialchars($_POST["email"]);
    $cellulare = htmlspecialchars($_POST["cellulare"]);
    $via = htmlspecialchars($_POST["via"]);
    $cap = htmlspecialchars($_POST["cap"]);
    $comune = htmlspecialchars($_POST["comune"]);
    $provincia = htmlspecialchars($_POST["provincia"]);
    $nickname = htmlspecialchars($_POST["nickname"]);
    $password = htmlspecialchars($_POST["password"]);

    // Stampo i dati
    echo "<h1>Dati Utente</h1>";
    echo "<p><strong>Nome:</strong> $nome</p>";
    echo "<p><strong>Cognome:</strong> $cognome</p>";
    echo "<p><strong>Data di Nascita:</strong> $data_nascita</p>";
    echo "<p><strong>Codice Fiscale:</strong> " . ($codice_fiscale ? $codice_fiscale : "Non fornito") . "</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Cellulare:</strong> " . ($cellulare ? $cellulare : "Non fornito") . "</p>";
    echo "<p><strong>Indirizzo:</strong> $via, $cap, $comune, $provincia</p>";
    echo "<p><strong>Nickname:</strong> $nickname</p>";
    echo "<p><strong>Password:</strong> ********</p>"; // Non stampo la password
    echo "<!-- link per tornare a Esercizio8.html -->
            <a href='esercizio8.html'>torna al modulo</a>";
} else {
    echo "<p>Errore: il form non è stato inviato correttamente.</p>";
}
?>
