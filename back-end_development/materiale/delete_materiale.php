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
    $query = $db -> prepare('DELETE FROM techseum.materiali WHERE codmateriale=:CodiceMateriale'); // PDO
    $query -> bindValue(':CodiceMateriale', $_POST['CodiceMateriale']); 
    $query -> execute();
  
    echo '{"status":1, "data":"Materiale eliminato correttamente"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}