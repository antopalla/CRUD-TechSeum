<?php

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Utilizzo del try - catch per eventuali errori nella query
try {
    $query = $db -> prepare('SELECT username,nome,cognome,amministratore FROM techseum.utenti'); // PDO
    $query -> execute();
    $righe_tabella = $query -> fetchAll();

       
    for($i=0;$i<count($righe_tabella);$i++) {
        if($righe_tabella[$i]['amministratore']==1)
            $righe_tabella[$i]['amministratore']="SI";
        if($righe_tabella[$i]['amministratore']==0)
            $righe_tabella[$i]['amministratore']="NO";
    }
    // Output dell'API in formato JSON
    echo '{"status":1, "data":'.json_encode($righe_tabella).'}';
    exit();

    } catch(PDOException $ex){
        err("Errore nell'esecuzione della query", __LINE__);
}



