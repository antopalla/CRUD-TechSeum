<?php

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

if(!isset($_POST['CodiceMateriale'])) {
    err('Identificativo del materiale mancante: ', __LINE__);
}

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try{
    $query = $db -> prepare('SELECT nomemateriale FROM techseum.materiali WHERE codmateriale=:CodiceMateriale LIMIT 1'); // PDO
    $query -> bindValue(':CodiceMateriale', $_POST['CodiceMateriale']); 
    $query -> execute();
    $righe_tabella = $query -> fetchAll();

    // Output dell'API in formato JSON
    echo '{"status":1, "data":'.json_encode($righe_tabella).'}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}