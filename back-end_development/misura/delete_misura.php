<?php
    // API PER LA RIMOZIONE DI UNA MISURA DAL DATABASE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/connessioneDB.php');

    // Controllo parametri in ingresso
    if (!isset($_GET['tipomisura'])) {
        err('Parametri per query mancanti', __LINE__);
    }

    // Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    try {
        $query = $db -> prepare('DELETE FROM techseum.nomimisure WHERE tipomisura=:tipomisura'); 
        $query -> bindValue(':tipomisura', $_GET['tipomisura']); 
        $query -> execute();
        
        // Output dell'API in formato JSON
        echo '{"status":1, "data":"misura eliminata"}';
        exit();

    } catch(PDOException $ex) {
        err("Errore nell'esecuzione della query", __LINE__);
    }