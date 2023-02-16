<?php

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

if(!isset($_POST['NomeMateriale'])) {
    err('Nome del materiale mancante: ', __LINE__);
}

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try{
    $query = $db -> prepare('INSERT INTO  techseum.materiali(codmateriale,nomemateriale) VALUES (NULL, :NomeMateriale)'); // PDO
    $query -> bindValue(':NomeMateriale', $_POST['NomeMateriale']); 
    $query -> execute();
  
    echo '{"status":1, "data":"Materiale creato"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}