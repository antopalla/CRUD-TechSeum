<?php

// Header per abilitare la richiesta alla API
header('Access-Control-Allow-Origin: *');

// Header per indicare che le richieste HTTP sono in formato JSON
header('Content-Type: application/json');

// Sessione e controllo login
session_start();
if (!$_SESSION["loggedIn"]) {
    header("Location: xxxxx"); // --> Inserire link della pagine di login
    die;
}

// Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["username"] $credenziali["password"] $credenziali["nome"] $credenziali["cognome"] $credenziali["amministratore]
//$credenziali = json_decode(file_get_contents('php://input'), true);

// Connessione al database (require_once = sostituisce la riga di codice con il codice contenuto nel file al path)
require_once(__DIR__.'/protected/database.php');

// Utilizzo del try - catch per eventuali errori nella query
try{
    $query = $db -> prepare('INSERT INTO techseum.utenti(username, password, nome, cognome, amministratore) VALUES (:username, :password, :nome, :cognome, :amministratore);'); // PDO
    $query -> bindValue(':username', $_POST['username']); // NO SQL INJECTION
    $query -> bindValue(':password', $_POST['password']); // NO SQL INJECTION --> Fare md5 da SvelteKIT
    $query -> bindValue(':nome', $_POST['nome']); // NO SQL INJECTION
    $query -> bindValue(':cognome', $_POST['cognome']); // NO SQL INJECTION
    $query -> bindValue(':amministratore', $_POST['amministratore']); // NO SQL INJECTION
    $query -> execute();
  
    echo '{"status":1, "data":"Utenza creata"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}

// Funzione per generare messaggio di errore
function err($message = 'error', $debug = 0) {
    echo '{ "status":0,
            "message":"'.$message.'",
            "debug":'.$debug.'}';
    exit();
}