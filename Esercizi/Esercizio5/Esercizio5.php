<!DOCTYPE html>
<head>
    <title>Login o Registrazione</title>
</head>
<body>
    <h1>Benvenuto</h1>
    <p>Scegli un'opzione:</p>

    <h2>Registrati</h2>
    <!-- manda in azione a Handler.php che gestisce i dati e la logica, usa il metodo post per nascondere i dati -->
    <form action="Handler.php" method="POST">
        <!-- comando trovato stackoverflow che viene utilizzato per inviare senza che i dati possano essere modificati o letti 
                "value" manderà il comando che l'utente ha scelto -->
        <input type="hidden" name="action" value="register">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>
        <label for="cognome">Cognome:</label>
        <input type="text" id="cognome" name="cognome" required><br>
        <label for="username">Nome utente:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <!-- select apre una taparella che fa scegliere tra una opzione predefinita -->
        <label for="sesso">Sesso:</label>
        <select id="sesso" name="sesso" required>
            <option value="maschio">Maschio</option>
            <option value="femmina">Femmina</option>
            <option value="altro">Altro</option>
        </select><br>
        <!-- manda in esecuzione l'azione -->
        <button type="submit">Registrati</button>
    </form>

    <h2>Accedi</h2>
    <!-- stesse cose scritte sopra -->
    <form action="Handler.php" method="POST">
        <input type="hidden" name="action" value="login">
        <label for="username_login">Nome utente:</label>
        <input type="text" id="username_login" name="username" required><br>
        <label for="password_login">Password:</label>
        <input type="password" id="password_login" name="password" required><br>
        <!-- manda in esecuzione l'azione -->
        <button type="submit">Accedi</button>
    </form>
    <br>
    <!-- link per tornare a index.html -->
    <a href="..\..\index.html">torna all'indice</a>
</body>
</html>
