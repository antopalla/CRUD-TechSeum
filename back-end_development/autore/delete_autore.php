<?php

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

if(!isset($_POST['codautore'])) {
    err('codautore mancanti', __LINE__);
}


try{
    $query = $db -> prepare('DELETE FROM techseum.autore WHERE codautore=:codautore;'); # elimina autore
    $query -> bindValue(':codautore', $_POST['codautore']); 
    $query -> execute();
    echo '{"status":1, "data":"autore cancellato"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}

