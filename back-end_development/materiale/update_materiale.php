<?php
    // API PER LA L'AGGIORNAMENTO DI UNA MISURA SUL DATABASE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/connessioneDB.php');

    // Controllo parametri in ingresso
    if (!isset($_POST['codmateriale']) or !isset($_POST['nomemateriale'])) {
        err('Parametri per query mancanti', __LINE__); 
    }

    // Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    try {
        $query = $db -> prepare('UPDATE techseum.materiali SET materiali.nomemateriale=:nomemateriale WHERE materiali.codmateriale=:codmateriale;');
        $query -> bindValue(':codmateriale', $_POST['codmateriale']); 
        $query -> bindValue(':nomemateriale', $_POST['nomemateriale']); 
        $query -> execute();
    
        echo '{"status":1, "data":"Materiale aggiornato"}';
        exit();

    } catch(PDOException $ex) {
        err("Errore nell'esecuzione della query", __LINE__);
    }