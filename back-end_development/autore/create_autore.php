<?php
    // API PER LA L'AGGIUNTA DI UN AUTORE AL DATABASE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/connessioneDB.php');

    // Controllo parametri in ingresso
    if (!isset($_POST['nomeautore']) || !isset($_POST['annonascita']) || !isset($_POST['annofine'])) {
        err('Parametri per query mancanti', __LINE__);
    }

    // Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    try {
        $query = $db -> prepare('INSERT INTO techseum.autore(nomeautore, annonascita, annofine) VALUES (:nomeautore, :annonascita, :annofine);');
        $query -> bindValue(':nomeautore', $_POST['nomeautore']); 
        $query -> bindValue(':annonascita', $_POST['annonascita']);
        $query -> bindValue(':annofine', $_POST['annofine']); 
        $query -> execute();

        // Output dell'API in formato JSON
        echo '{"status":1, "data":"Autore aggiunto al database"}';
        exit();

    } catch(PDOException $ex) {
        err("Errore nell'esecuzione della query", __LINE__);
    }
