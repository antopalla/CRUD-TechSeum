<?php
    // API PER LA L'ESTRAZIONE DI UN AUTORE DAL DATABASE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/connessioneDB.php');

    // Controllo parametri in ingresso
    if (!isset($_GET['codautore'])) {
        err('Parametri per query mancanti', __LINE__);
    }

    // Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    try {
        $query = $db -> prepare('SELECT nomeautore,annonascita,annofine FROM techseum.autore where codautore=:codautore LIMIT 1');
        $query -> bindValue(':codautore', $_GET['codautore']);
        $query -> execute();
        $righe_tabella = $query -> fetchAll();

        // Conversione in JSON e poi da trasformazione del "codautore" ad "id" come indice della colonna SQL
        $output = json_encode($righe_tabella);
        $output = str_replace("codautore", "id", $output);

        // Output dell'API in formato JSON
        echo '{"status":1, "data":'.$output.'}';
        exit();

        } catch(PDOException $ex) {
            err("Errore nell'esecuzione della query", __LINE__);
    }