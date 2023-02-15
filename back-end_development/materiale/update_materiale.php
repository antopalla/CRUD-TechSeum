<?php

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

if(!isset($_POST['CodiceMateriale']) or !isset($_POST['NomeMateriale'])) {
    err('Nome del materiale o identificativo mancante: ', __LINE__);
}

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try{
    $query = $db -> prepare('UPDATE techseum.materiali SET materiali.nomemateriale=:NomeMateriale WHERE materiali.codmateriale=:CodiceMateriale;'); // PDO
    $query -> bindValue(':CodiceMateriale', $_POST['CodiceMateriale']); 
    $query -> bindValue(':NomeMateriale', $_POST['NomeMateriale']); 
    $query -> execute();
  
    echo '{"status":1, "data":"Materiale aggiornato correttamente!!"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}