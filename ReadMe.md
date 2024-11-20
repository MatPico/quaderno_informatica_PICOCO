
# Quaderno Picoco Informatica 

In questo codice non vengono implementati script e style, come da consegna.   
Vengono però richiesti in alcuni esercizi, vengono utilizzate mecchaniche esterne ai comandi css e js.   
Sono presenti codici creati solo per comprendere meglio le meccaniche e codici richiesti dai professori che verranno segnalati tramite messaggio.   
GitHub : @Mat_pico    
Versione appunti: 1.0.1    

**Ultima patch:** Aggiunti esercizi 10 e 11

---

## Il Protocollo HTTP

**HTTP (Hypertext Transfer Protocol)** è un protocollo di comunicazione usato per trasmettere dati tra client e server. Utilizza un modello **client-server**:
- Il **client** invia richieste tramite metodi HTTP come `GET`, `POST`, `PUT`, e `DELETE`.
- Il **server** risponde con codici di stato (`200 OK`, `404 Not Found`) e contenuti.

### Esempi:
#### Richiesta:
```http
GET /index.html HTTP/1.1
Host: www.example.com
```
#### Risposta:
```http
HTTP/1.1 200 OK
Content-Type: text/html
<html>
  <body>Welcome!</body>
</html>
```

HTTP/2 è l'evoluzione che migliora prestazioni con richieste simultanee e compressione dati.

---

## Introduzione a PHP

**PHP (Hypertext Preprocessor)** è un linguaggio server-side per creare contenuti dinamici sul web. È:
- **Case-sensitive** (le variabili `$nome` e `$Nome` sono diverse).
- **Whitespace-insensitive** (gli spazi non influiscono sul codice, ad eccezione delle stringhe).

### Struttura base:
```php
<?php
echo "Ciao mondo!";
?>
```

### Variabili e Costanti:
- Dichiarazione di variabili: `$nome = "Mario";`
- Dichiarazione di costanti:
```php
define("PI", 3.14);
const VERSIONE = "1.0";
```

---

## Introduzione ai Form HTML

I **form HTML** consentono agli utenti di interagire con le pagine web inviando dati al server.   
### Struttura base:
```html
<form action="login.php" method="POST">
  <label for="username">Username:</label>
  <input type="text" id="username" name="username" required>
  <label for="password">Password:</label>
  <input type="password" id="password" name="password" required>
  <button type="submit">Login</button>
</form>
```
### Metodi di input:   

I **form HTML** hanno speso dati di input, che permettono all'utente di inserire dati che verranno poi processati.   
```html
<form action="login.php" method="POST">
  <input type="text"> per inserire testo
  <input type="password"> per inserire password
  <input type="radio"> per selezionare una sola opzione tra diverse
  <input type="checkbox"> per selezionare una o più opzioni tra diverse
  <input type="submit"> per inviare i dati del form
</form>
```
### Invio di dati dal form:   
- HTML fornisce tag per la visualizzazione e la formattazione tramite html.   
- Nel momento in cui l'utente usa un metodo **submit** i dati nel form vengono mandati ad un destinatario **action**.   
- I dati vengono inviati tramite 2 principali metodi:   

#### Metodo Get:
- I parametri sono passati in chiaro accodandoli al `URL` della pagina.
- Essendo visibile potrebbe essere costruita artificialmente.
- La lunghezza massima è `256` caratteri.

#### Metodo Post:
- I paramtri sono passati direttamente tramite protoccolo `http`.
- I dati non sono visibili e non vengono mostrati nell'URL.

#### Lettura dei dati inviati:
```php
    <?php
    // Recupera i dati inviati dal form di registrazione
    $nome = $_POST['nome'];             // Nome dell'utente
    $cognome = $_POST['cognome'];       // Cognome dell'utente
    $username = $_POST['username'];     // Nome utente scelto
    $password = $_POST['password'];     // Password scelta
    $email = $_POST['email'];           // Email dell'utente
    $sesso = $_POST['sesso'];           // Sesso dell'utente
    ?>
```
---

### Postback:
 Il **Postback** è il comportamento di far inserire i dati in un form e inviarli come `action` sulla stessa pagina php.   

--- 

## Stringhe:
- Stringhe di massimo **256** caratteri.   
- Possono essere usati `quote` o `doubleQuote`.   
- `DoubleQuote` permettono l'interpretazione delle variabili.   

```php
<?php
    strlen(): //calcola la lunghezza di una stringa.
    strpos(): //trova la posizione di una sottostringa.
    str_replace(): //sostituisce parte di una stringa.
    explode(): //scompone una stringa in un array.
    trim(): //rimuove spazi all'inizio e alla fine della stringa.
?>
```

- `Heredoc` è un metodo si sintassi multilinea, si può usare per dare a varriabili interi blocchi di codice (heredoc `legge` le variabili).   
- `Nowdoc` è un metodo si sintassi multilinea, si può usare per dare a varriabili interi blocchi di codice (Nowdoc `NON legge` le variabili).   

---

## Funzioni:
Le funzioni su php, come su altri linguaggi, sono **blocchi di codice** richiamabili più volte ovunque nel codice.   

```php
    function nome_funzione($parametro1, $parametro2, ...) {
    // istruzioni
    return $valore;
    }
```
- Non è possibile dare in return più di 1 valore, ma è possibile returnare un array.
- Dopo aver implementato le funzioni possiamo anche identificare diversi usi delle variabili:   

#### Globale:
Per **globale** si intende una variabile definita nel codice che può essere **vista da tutti**.
```php
    //variabile globale
    $value = 1;
    aumenta();

    function aumenta() {
    //modifica
    $value = $value + 1;
    }
```

#### Locale:
Per **locale** si intende una variabile nata all'interno di una frazione non principale del codice, come una funzione.
```php
    //variabile globale
    $valoreGlobale = 1;
    //richiamo la funzioni
    funzione($valoreGlobale);

    function funzione($dato) {
    //creo una variabile locale a cui do il valore passato al richiamo e lo aumento di 1
    $valoreLocale = $dato;
    $valoreLocale = $valoreLocale + 1;
    }
```

#### Statica
A differenza della variabile locale, che una volta conclusa la funzione muore, la **statica** rimane attiva anche nelle prossime chiamate della funzione.
```php
    //funzione con variabile statica che rimarrà in vita e con lo stesso valore
    //aumentando ogni volta che la funzione viene richiamata
    function contatore() {
    static $contatore = 0;
    $contatore++;
    echo $contatore;
    }
    miaFunzione(); // stampa 1
    miaFunzione(); // stampa 2
    miaFunzione(); // stampa 3

```

---

## Form validation
Per **Form Validation** si intendono tutte quelle tecniche adottate su un valore di un form che ci aiutano a gestire i valori desiderati.   
Alcune tra queste sono:
```html
<form action="login.php" method="POST">
  <input type="text"> tipo di testo
  <input type="select" autocomplete> suggerisce dai dati salvati del browser delle risposte
  <input type="password" required> obbligatoria per poter usare il submit
  <input type="text" pattern=""> permettere di gestire quale campo di caratteri è accetto e come
  <input type="text" minlength="" maxlength=""> indicano i valori massimi e minimi di caratteri
  <input type="number" step=""> quanti numeri il codice aggiunge o toglie
  <input type="number" min="" max=""> numero massimo e minimo (solo numeri)
</form>
```

### Pattern
Tra questi il **Pattern** è sicuramente il comando più versalite.   
Permette infatti fin da subito **bloccare i dati** già prima di essere `inviati al PHP`.   
Il Pattern può obbligare e controllare, tipo di carattere, quantità e altro.   

#### Pattern che accettano caratteri:
Sono `range di caratteri` che vengono **accettati dal codice**.
```php
    /*
      A-Z = tutte le lettere maiuscole
      a-z = tutte le lettere minuscole
      \d = tutti i numeri
      \s = lo spazio tra una parola e un'altra
      \. = un punto, ovvero qualsiasi carattere
      ^ = indica l'inizio della stringa
    */
```
#### Pattern che obbliga la scelta dell'utente:
Sono **comandi** che stabiliscono `l'informazione voluta dal codice`.
```php
    /*
      ? = vuole dire che può essercene solo 1 o nessuno
      * = vuole dire che può non esserci
      + = vuole dire che possono essere quanti caratteri voglio ripetuti
      {numero} = forzo un numero di caratteri, tipo codice fiscale
      {numero,} = un numero di caratteri che deve essere minimo quel numero
      {minimo,massimo} = un numero di caratteri tra un intervallo 
    */
```

---
