<?php

require_once(__DIR__.'/protected/headers.php');
require_once(__DIR__.'/protected/functions.php');
require_once(__DIR__.'/protected/check_session.php');
require_once(__DIR__.'/protected/connessioneDB.php');

// Utilizzo del try - catch per eventuali errori nella query
try {
    $query = $db -> prepare('SELECT * FROM techseum.repertinuova'); // PDO
    $query -> execute();
    $righe_tabella = $query -> fetchAll();

    // Conversione da lettera rappresentante la sezione a parola intera
    for($i=0;$i<count($righe_tabella);$i++) {
        if($righe_tabella[$i]['sezione']=="E")
            $righe_tabella[$i]['sezione']="Elettrotecnica";
        if($righe_tabella[$i]['sezione']=="I")
            $righe_tabella[$i]['sezione']="Informatica";
        if($righe_tabella[$i]['sezione']=="M")
            $righe_tabella[$i]['sezione']="Meccanica";
        if($righe_tabella[$i]['sezione']=="S")
            $righe_tabella[$i]['sezione']="Scienze";
    }

    // Output dell'API in formato JSON
    echo '{"status":1, "data":'.json_encode($righe_tabella).'}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}


