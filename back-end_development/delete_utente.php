<?php

require_once(__DIR__.'/protected/headers.php');
require_once(__DIR__.'/protected/functions.php');
require_once(__DIR__.'/protected/check_session.php');
require_once(__DIR__.'/protected/connessioneDB.php');

// Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["username"] $credenziali["password"] $credenziali["nome"] $credenziali["cognome"] $credenziali["amministratore]
//$credenziali = json_decode(file_get_contents('php://input'), true);

// Utilizzo del try - catch per eventuali errori nella query
try{
    $query = $db -> prepare('DELETE FROM techseum.utenti WHERE username=:username AND password=:password;'); // QUERY DI ELIMINAZIONE DELL' UTENZA
    $query -> bindValue(':username', $_POST['username']); // NO SQL INJECTION
    $query -> bindValue(':password', $_POST['password']); // NO SQL INJECTION --> Fare md5 da SvelteKIT
    $query -> execute();
  
    echo '{"status":1, "data":"Utenza cancellata"}';
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