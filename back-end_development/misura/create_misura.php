<?php
    // API PER L'AGGIUNTA DI UNA MISURA AL DATABASE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/connessioneDB.php');

    // Controllo parametri in ingresso
    if (!isset($_POST['nomemisura']) or !isset($_POST['unitadimisura']) or !isset($_POST['tipomisura'])) {
        err('Parametri per query mancanti', __LINE__);
    }

    // Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    try {
        $query = $db -> prepare('INSERT INTO nomimisure(tipomisura,nomemisura,unitadimisura) VALUES (:tipomisura,:nomemisura,:unitadimisura);'); 
        $query -> bindValue(':tipomisura', $_POST['tipomisura']);
        $query -> bindValue(':nomemisura', $_POST['nomemisura']); 
        $query -> bindValue(':unitadimisura', $_POST['unitadimisura']);
        $query -> execute();
    
        // Output dell'API in formato JSON
        echo '{"status":1, "data":"Misura aggiunta al database"}';
        exit();

    } catch(PDOException $ex) {
        err("Errore nell'esecuzione della query", __LINE__);
    }