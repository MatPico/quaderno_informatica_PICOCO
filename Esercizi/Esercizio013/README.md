[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-22041afd0340ce965d47ae6ef1cefeee28c7c493a6346c4f15d667ab976d596c.svg)](https://classroom.github.com/a/T6gmiR_L)
[![Open in Visual Studio Code](https://classroom.github.com/assets/open-in-vscode-2e0aaae1b6195c2367325f4f02e2d04e9abb55f0b24a779b69b11b9e10269abc.svg)](https://classroom.github.com/online_ide?assignment_repo_id=18221749&assignment_repo_type=AssignmentRepo)

# Compito: Traccia esame 2017
Carpooling versione 1.1   
Compito svolto dal gruppo BigSblao:
+   *Picoco Mattia*: Codice
+   *Alessandra Gabriele*: Documentazione
+   *Fabiano Giuseppe*: Analisi funzionali e bozze

## Indice
1. Introduzione
   - 1.1 Scopo del Progetto
   - 1.2 Supposizioni
2. Architettura del Progetto
   - 2.1 Struttura generale
   - 2.2 Gestione del DataBase
   - 2.3 Flusso di Navigazione
   - 2.4 Sicurezza
3. Descrizione e spiegazione del codice (Lettura sconsigliata)

## 1. Introduzione

### 1.1 Scopo del Progetto
Viene richiesto di realizzare un sito con le seguenti funzioni: 
```
Un'azienda start-up vuole creare una piattaforma web per il car pooling in Italia, promuovendo una mobilità flessibile. Gli utenti sono autisti, che offrono passaggi, e passeggeri.   
Vengono richieste le seguenti funzioni:

Autisti: devono registrarsi con i propri dati, patente, auto e recapiti. Per ogni viaggio, inseriscono dettagli come città, data, contributo economico e tempi di percorrenza. Possono chiudere le prenotazioni quando il viaggio è completo.

Passeggeri: si registrano e inseriscono città, destinazione e data desiderata. Possono scegliere un viaggio disponibile, basandosi sui feedback e voti degli autisti, e prenotarsi. L’autista può accettare o rifiutare la richiesta.

Feedback: dopo il viaggio, autisti e passeggeri lasciano un feedback con voto e commento. I feedback sono visibili a entrambi, migliorando la trasparenza e la fiducia tra gli utenti.
```

### 1.2 Supposizioni
Nel progetto si assume che:
- Gli utenti sono già a conoscenza del concetto di car pooling e della necessità di registrarsi per poter utilizzare la piattaforma.
- La validazione dell'input da parte degli utenti è minimizzata per evitare errori evidenti, ma si assume che i dati inseriti siano corretti.
- L'infrastruttura backend è già predisposta per la gestione di una base di dati MySQL.
- Gli utenti possono lasciare una valutazione univoca che sarà sempre visibile a tutti gli utenti.
- L'interfaccia è intuitiva e guida una facile navigazione.
- Il codice è commentato e formattato con AI (Claude).

## 2. Architettura del Progetto

### 2.1 Struttura Generale
Il sistema è costruito su una piattaforma web con PHP per il backend, utilizzando MySQL come sistema di gestione del database. Gli utenti interagiscono con il sistema tramite una serie di pagine web interattive che consentono la registrazione, la gestione dei viaggi, le prenotazioni e le valutazioni.

Il flusso dell'applicazione si articola come segue:
1. **Registrazione/Accesso degli utenti**: Gli utenti, sia autisti che passeggeri, si registrano e accedono tramite moduli HTML. I dati vengono poi inviati al server, dove vengono validati e archiviati nel database.
2. **Creazione di viaggi**: Gli autisti creano nuovi viaggi, specificando le informazioni relative al percorso, data e disponibilità. Questi dati vengono archiviati nel database.
3. **Prenotazione di viaggi**: I passeggeri possono cercare viaggi disponibili in base alla città di partenza, di arrivo e alla fascia economica, e successivamente prenotare un posto per un viaggio.
4. **Rifiuto delle prenotazioni**: Gli autisti possono rifiutare le prenotazioni.
5. **Gestione del viaggio**: Gli autisti possono cancellare il viaggio o chiuderlo nel momento di arrivo.
6. **Valutazioni**: Dopo ogni viaggio, sia gli autisti che i passeggeri possono lasciare un feedback relativo all'esperienza di viaggio, con un voto (da 1 a 5) e una descrizione.

### 2.2 Gestione del Database
Il sistema si basa su un database MySQL che contiene tabelle per gestire gli utenti, i viaggi, le prenotazioni e le valutazioni. Le principali tabelle del database includono:
- **utenti**: Contiene i dati degli utenti (autisti e passeggeri).
- **macchina**: Contiene i dati relativi alle auto degli autisti.
- **viaggi**: Contiene le informazioni sui viaggi offerti dagli autisti.
- **prenotazioni**: Gestisce le prenotazioni effettuate dai passeggeri per i viaggi.
- **valutazioni**: Archivia i feedback lasciati dagli utenti dopo ogni viaggio.   

Il database usa come struttura la seguente:
```sql
CREATE DATABASE carpooling;

USE carpooling;

CREATE TABLE autista (
    id_autista INT AUTO_INCREMENT PRIMARY KEY,
    id_macchina INT,
    nome VARCHAR(50),
    cognome VARCHAR(50),
    numero VARCHAR(15),
    numero_patente VARCHAR(20),
    scadenza_patente DATE,
    mail VARCHAR(100),
    password VARCHAR(255),
    ruolo ENUM('autista', 'passeggero')
);

CREATE TABLE passeggero (
    id_passeggero INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50),
    cognome VARCHAR(50),
    numero VARCHAR(15),
    numero_carta_identita VARCHAR(20),
    mail VARCHAR(100),
    password VARCHAR(255),
    ruolo ENUM('autista', 'passeggero')
);

CREATE TABLE Macchina (
    id_macchina INT AUTO_INCREMENT PRIMARY KEY,
    colore VARCHAR(20),
    modello VARCHAR(50),
    marca VARCHAR(50),
    anno YEAR,
    posti INT
);

CREATE TABLE Viaggio (
    id_viaggio INT AUTO_INCREMENT PRIMARY KEY,
    id_autista INT,
    citta_partenza VARCHAR(100),
    citta_arrivo VARCHAR(100),
    ora_partenza DATETIME,
    ora_arrivo DATETIME,
    tempo_stimato TIME,
    contributo_economico DECIMAL(10, 2),
    max_posti INT,
    stato ENUM('attivo', 'chiuso', 'cancellato'),
    FOREIGN KEY (id_autista) REFERENCES autista(id_autista)
);

CREATE TABLE prenotazione (
    id_prenotazione INT AUTO_INCREMENT PRIMARY KEY,
    id_viaggio INT,
    id_passeggero INT,
    stato ENUM('attiva', 'rifiutata','chiusa','cancellata') DEFAULT 'attiva',
    FOREIGN KEY (id_viaggio) REFERENCES Viaggio(id_viaggio),
    FOREIGN KEY (id_passeggero) REFERENCES passeggero(id_passeggero)
);

CREATE TABLE Valutazione (
    id_valutazione INT AUTO_INCREMENT PRIMARY KEY,
    id_autista INT,
    id_passeggero INT,
    voto INT,
    descrizione TEXT,
	ruolo ENUM('autista', 'passeggero'),
    FOREIGN KEY (id_autista) REFERENCES autista(id_autista),
    FOREIGN KEY (id_passeggero) REFERENCES passeggero(id_passeggero)
);
```
### 2.3 Flusso di Navigazione

1. **Entrata del sito**: Entrato nel sito l'utente potrà accedere come autista o passeggero, è presente anche un pulsante per registrarsi se nuovi al sito:
    - **1.1 Registrarsi da autista**: Vengono richiesti i dati anagrafici, il numero e la scadenza della patente, un numero telefonico, i dati dell'auto, una mail ed una password.
    - **1.2 Registrarsi da passeggero**: Vengono richiesti i dati anagrafici, il numero della carta di identità, un numero telefonico, una mail ed una password.
L'utente potrà quindi poi accedere.

2. **Pagina di controllo (Dashboard)**: Una pagina con presenti dei pulsanti che permetterano all'utente di usare un servizio
    - **2.1 Dashboard autista**: contiene:
        - Pulsante gestione viaggi autista
        - Pulsante crea viaggi
        - Pulsante uscita
        - Pulsante mostra profilo
        - Pulsante aggiorna auto
    - **2.2 Dashboard passeggero**: contiene:
        - Pulsante ricerca viaggi
        - Pulsante gestione viaggi passeggero
        - Pulsante mostra profilo
        - Pulsante uscita
    
+ **Pulsante uscita**: Porta l'utente alla pagina di accesso.
+ **Pulsante mostra profilo**: Mostra il profilo dell'utente selezionato, mostrando dati utili e recensioni.
+ **Pulsante aggiorna auto**: Mostra i dati dell'auto, dando la possibilità di modificarli.
+ **Pulsante ricerca viaggi**: Cerca un viaggio in base a 3 dati (partenza, arrivo e costo), presenta un pulsante per prenotare il viaggio e per visionare l'autista.
+ **Pulsante crea viaggi**: Permette all'autista di creare un viaggio, riempiendo i campi richiesti (tabella entità Viaggio).
+ **Pulsante gestione viaggi autista**: Mostra la lista di tutti i viaggi (attivi, cancellati e chiusi), permette di visionare i profili dei passeggeri e poi rifiutarli, permette di chiudere o cancellare i viaggi ancora attivi e se chiusi permette di valutare un passeggero.
+ **Pulsante gestione viaggi passeggero**: Mostra la lista di tutte le prenotazioni dell'utente (attive, cancellate, rifiutate o chiuse), può vedere il profilo dell'autista e valutarlo se a viaggio chiuso.

### 2.4 Sicurezza
La sicurezza è gestita principalmente tramite:
- **Hashing della password**: Le password degli utenti vengono salvate nel database in formato sicuro tramite hashing, evitando il salvataggio in chiaro.
- **Sessioni e gestione accessi**: L'accesso alla piattaforma è protetto tramite sessioni, assicurandosi che solo gli utenti loggati possano accedere alle funzionalità riservate.
- **Validazione dell'input**: Sebbene non approfondita, viene comunque eseguita una minima validazione dell'input degli utenti per evitare l'inserimento di dati non validi, viene anche usata una funzione bind_param.

## 3. Descrizione e spiegazione del codice (Lettura sconsigliata)
 - `index.html` 
 La pagina iniziale del sito, permette all'utente (tramite 2 form) di inserire i suoi dati di accesso in base al ruolo ricoperto nel sito.   
 I dati verranno mandati rispettivamente nel PHP di login del ruolo selezionato (`login_autista.php` e `login_passeggero.php`).   
 viene anche inserito un link che porta alla pagina html per la registrazione `registrazione.html`
 ---
 - `registrazione.html`   
 Permetterà all'utente di registrarsi sempre in base a 2 form distinti e poi mandando i dati alla pagina `registrazione_autista.php` o `registrazione_passeggero.php`
 ---
 - `registrazione_autista.php`   
 Crea una connessione con il db usando:
 ```php
 // crea una nuova connessione al database MySQL
 $conn = new mysqli($servername, $username, $password, $dbname);
 ```
 Raccoglierà le informazioni e cripterà la password usando una chiave
 ```php
 $password = password_hash($_POST['password_autista'], PASSWORD_DEFAULT);  // recupera e cripta la password dell'autista
 ```
 Inserisce le infromazioni raccolte in metodo post dal form di registrazioni in una variabile
 ```php
 // Inserisci i dati della macchina nel database
$sql_macchina = "INSERT INTO Macchina (colore, modello, marca, anno, posti) 
                 VALUES ('$colore_macchina', '$modello_macchina', '$marca_macchina', '$anno_macchina', '$posti_macchina')";
 // Inserisci i dati dell'autista nel database
$sql_autista = "INSERT INTO autista (id_macchina, nome, cognome, numero, numero_patente, scadenza_patente, mail, password, ruolo) 
                 VALUES ('$id_macchina', '$nome', '$cognome', '$numero', '$numero_patente', '$scadenza_patente', '$mail', '$password', 'autista')";
 ```
 Inserisce poi nel DB usando un **if** la variabile
 ```php
 // verifica se la query per inserire l'autista è stata eseguita con successo
    if ($conn->query($sql_autista)) {
        echo "Registrazione completata con successo!";  // messaggio di successo se l'autista è stato registrato correttamente
    }
 ```
 Abbiamo scelto questa soluzione perchè se la query va a buon fine returna **true** stamperà il messaggio di successo.   
 Mentre se returna false mostrerà gli errori con un else.    

---
- `registrazione_passeggero.php`   
Farà lo stesso lavoro di autista, senza contare la macchina.   
Avrà come unica differenza la destinazione della query
```php
// Inserisce i dati del passeggero nel database
$sql = "INSERT INTO passeggero (nome, cognome, numero, numero_carta_identita, mail, password, ruolo) 
        VALUES ('$nome', '$cognome', '$numero', '$numero_carta_identita', '$mail', '$password', 'passeggero')";
```
---
- `login_autista.php`   
Raccoglie i dati dal form di accesso   
Apre la connessione al DB e cerca la tupla avente la stessa mail inserita
```php
// Query per selezionare l'autista con la mail specificata
$sql = "SELECT * FROM autista WHERE mail='$mail'";
$result = $conn->query($sql);
```
Va poi a paragonare la password salvata con quella inserita all'accesso
```php
password_verify($password, $row['password'])
```
Ricordiamo che le password salvate sul DB sono cripate usando la chiave default di **php**   
Password_verify paragona la chiave salvata con quella inserita, ovviamente le 2 sono diverse   
Quindi lui andrà a criptare con la stessa chiave la password inserita, per poi paragonarle correttamente   
+ Essendo che usiamo la chiave default, non va precisato l'algoritmo nel password_verify   

Infine inoltrerà la sessione aperta e riempita di informazioni alla **dashboard**
```php
// Reindirizza alla dashboard dell'autista
        header("Location: dashboard_autista.php");
```
---
- `login_passeggero.php`   
Contiene la stessa logica di autista, ma abbiamo voluto sperimentare una query preparata   
Questo permette di non avere delle **SQL INJECTION**
```php
// Recupera i dati inviati dal form
$mail = $_POST['mail_passeggero'];
$password = $_POST['password_passeggero'];

// Prepara la query sql, mettendo un punto di domanda al posto del dato della mail 
$sql = "SELECT * FROM passeggero WHERE mail=?";
// Prepata la il dato, dandolo alla variabile stmt
$stmt = $conn->prepare($sql);

// Usando la funziona bind_param andiamo a sostituire il punto di domanda
// Il primo valore "s" definisce che sarà una stringa, il secondo è il valore inserito
$stmt->bind_param("s", $mail);

// Esegui la query
$stmt->execute();

// Ottieni il risultato
$result = $stmt->get_result();
```
---
- `dashboard_autista.php`   
Dalla dashboard in poi, ogni pagina avrà il seguente comando   
Comando che serve a leggere la variabile di sessione   
Leggendola il codice verifica se il ruolo sia corretto, in caso rimanda l'utente al login
```php
if (!isset($_SESSION['id_autista'])) {
    header("Location: index.html");
    exit();
}
```
Vengono poi stampati i pulsanti della dashboard   
Ogni pulsante porterà, con un comando in **javascript**, alla funzione premuta
```html
<!-- crea un bottone per andare alla pagina di creazione viaggio -->
<button onclick="location.href='crea_viaggio.php'">Crea Viaggio</button>
```
---
- `dashboard_passeggero.php`   
Svolge la stessa funzione di `dashboard_autista.php` ma con pulsanti differenti (come da navigazione)   

---
- `logout.php`   
Riprende la sessione attiva, la distrugge azzerandola e rimanda l'utente alla pagina di login   

---
- `profilo.php`   
La prima interfaccia in comune tra autista e passeggero, prende i dati dal URL
```
profilo.php?id=12&ruolo=passeggero
```
Prende quindi id e ruolo dell'utente di cui si stampa il profilo   
Se il ruolo è **autista** fa una query per ricevere le informazioni dell'utente e della sua macchina   
Se è **passeggero** prende solo i suoi dati   
```php
if ($ruolo_utente == 'autista') {
    $sql_utente = "SELECT a.*, m.colore, m.modello, m.marca, m.anno, m.posti 
                   FROM autista a 
                   JOIN Macchina m ON a.id_macchina = m.id_macchina 
                   WHERE a.id_autista='$id_utente'";
} else {
    $sql_utente = "SELECT * FROM passeggero WHERE id_passeggero='$id_utente'";
}
```
Recupera poi le valutazioni dove è presente il suo id   
Stampa i dati essenziali (se è autista stampa anche la macchina)   
Poi è presente un codice che dopo aver recuperato tutte le valutazioni, esclude quelle con il ruolo_mittente comune all'utente   
+ la tabella valutazione non ha paragoni per capire chi è che invia o riceve, usare un ruolo mittente invece permette di sapere se l'autore della valutazione è l'utente
+ es: un autista valuta un cliente, la valutazione avrà entrambi gli id e il ruolo di chi ha fatto la valutazione (autista). Nella stampa delle valutazioni verranno quindi escluse le recensioni che hanno il ruolo autista, perchè create da lui   
```php
if ($ruolo_utente == 'autista') {
    $sql_valutazioni = "SELECT v.voto, v.descrizione, p.nome, p.cognome 
                        FROM Valutazione v 
                        JOIN passeggero p ON v.id_passeggero = p.id_passeggero 
                        WHERE v.id_autista='$id_utente' AND v.ruolo = 'passeggero'";
} else {
    $sql_valutazioni = "SELECT v.voto, v.descrizione, a.nome, a.cognome 
                        FROM Valutazione v 
                        JOIN autista a ON v.id_autista = a.id_autista 
                        WHERE v.id_passeggero='$id_utente' AND v.ruolo = 'autista'";
}
```
---
- `modifica_macchina.php`   
Raccoglie l' ID utente dalla sessione   
Fa una query per raccogliere i dati dell'auto dell'utente usando la FK   
Crea un form in cui inserisce già i dati dell'auto esistente   
Quando viene premuto il **submit** il form crea una query che aggiorna i dati dell'auto
```php
// Query SQL per aggiornare i dati della macchina
    $sql_update = "UPDATE Macchina 
                   SET colore='$colore', modello='$modello', marca='$marca', anno='$anno', posti='$posti' 
                   WHERE id_macchina='{$macchina['id_macchina']}'";  // Aggiornamento della macchina

    if ($conn->query($sql_update)) {  // Esegue la query di aggiornamento
        $messaggio = "Dati della macchina aggiornati con successo!";  // Messaggio di successo
        // Ricarica i dati della macchina
        $result_macchina = $conn->query($sql_macchina);  // Esegue nuovamente la query
        $macchina = $result_macchina->fetch_assoc();  // Recupera i dati aggiornati
    } else {
        $errore = "Errore durante l'aggiornamento: " . $conn->error;  // Messaggio di errore in caso di fallimento
    }
```
---
- `crea_viaggio.php`   
Stampa un form che chiede le informazioni per la tabella/entità Viaggio   
Le manda a `salva_viaggio.php`   

---
- `salva_viaggio.php`   
Raccoglie i dati in post dal form in `crea_viaggio.php`   
Crea la query che salvera i dati su **viaggio**   
```php
$sql = "INSERT INTO Viaggio (id_autista, citta_partenza, citta_arrivo, ora_partenza, ora_arrivo, tempo_stimato, contributo_economico, max_posti, stato) 
VALUES ('$id_autista', '$citta_partenza', '$citta_arrivo', '$ora_partenza', '$ora_arrivo', '$tempo_stimato', '$contributo_economico', '$max_posti', 'attivo')";
```
---



