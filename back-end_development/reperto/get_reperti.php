<?php
// API PER L'ESTRAZIONE DEI REPERTI DEL DATABASE

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try {
    $query = $db -> prepare('SELECT repertinuova.*, autore.nomeautore FROM repertinuova , autore WHERE repertinuova.codrelativo = autore.codautore'); // PDO
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

   
    // Conversione in JSON e poi da trasformazione del "codassoluto" ad "id" come indice della colonna SQL
    $output = json_encode($righe_tabella);
    $output = str_replace("codassoluto", "id", $output);

    // Output dell'API in formato JSON
    echo '{"status":1, "data":'.$output.'}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}


