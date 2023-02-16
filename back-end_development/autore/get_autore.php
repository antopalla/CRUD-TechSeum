<?php

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

if(!isset($_POST['codautore'])) {
    err('codautore mancanti', __LINE__);
}

/// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try {
    $query = $db -> prepare('SELECT nomeautore,annonascita,annofine FROM techseum.autore where codautore=:codautore LIMIT 1'); // PDO
    $query -> bindValue(':codautore', $_POST['codautore']);
    $query -> execute();
    $righe_tabella = $query -> fetchAll();

    // Output dell'API in formato JSON
    echo '{"status":1, "data":'.json_encode($righe_tabella).'}';
    exit();

    } catch(PDOException $ex){
        err("Errore nell'esecuzione della query", __LINE__);
}
