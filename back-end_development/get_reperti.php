<?php

// Header per abilitare la richiesta alla API
header('Access-Control-Allow-Origin: *');

// Header per indicare che le richieste HTTP sono in formato JSON
header('Content-Type: application/json');

// Connessione al database (require_once = sostituisce la riga di codice con il codice contenuto nel file al path)
require_once(__DIR__.'/protected/database.php');

// Utilizzo del try - catch per eventuali errori nella query
try{
    $query = $db -> prepare('SELECT * FROM techseum.repertinuova'); // PDO
    $query -> execute();
    $righe_tabella = $query -> fetchAll();

    echo '{"status":1, "data":'.json_encode($righe_tabella).'}';
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

