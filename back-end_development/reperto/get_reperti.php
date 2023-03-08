<?php
    // API PER L'ESTRAZIONE DEI REPERTI DEL DATABASE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/connessioneDB.php');

    // Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    try {
        $query = $db -> prepare('SELECT DISTINCT r.*, a.nomeautore FROM repertinuova r LEFT JOIN hafatto h ON r.codassoluto = h.codassoluto LEFT JOIN autore a ON h.codautore = a.codautore GROUP BY r.codassoluto ORDER BY r.codassoluto');
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
            if($righe_tabella[$i]['nomeautore']==null)
                $righe_tabella[$i]['nomeautore']="Autore non presente";
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


