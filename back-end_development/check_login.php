<?php

require_once(__DIR__.'/protected/headers.php');
require_once(__DIR__.'/protected/functions.php');
require_once(__DIR__.'/protected/connessioneDB.php');

// Inizio della sessione
session_start();

// Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["username"] $credenziali["password"]
//$credenziali = json_decode(file_get_contents('php://input'), true);

// Controllo presenza username e password nel metodo POST
if(!isset($_POST['username']) or !isset($_POST['password'])) {
    err('Username o password mancanti', __LINE__);
}

// Utilizzo del try - catch per eventuali errori nella query
try{
    $query = $db -> prepare('SELECT * FROM techseum.utenti WHERE username = :username and password = :password LIMIT 1'); // PDO
    $query -> bindValue(':username', $_POST['username']); // NO SQL INJECTION
    $query -> bindValue(':password', $_POST['password']); // NO SQL INJECTION --> Fare md5 da SvelteKIT
    $query -> execute();
    $righe_tabella = $query -> fetchAll();

    if(!$righe_tabella) {
        err("Utente o password errati", 404);
        exit();
    }

    echo '{"status":1, "data":"Accesso consentito"}';

    // Impostiamo l'utente come loggato
    $_SESSION["loggedIn"] = true;
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}
