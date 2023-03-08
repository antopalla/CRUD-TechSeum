<?php
    // API PER LA L'AGGIUNTA DI UN MATERIALE DAL DATABASE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/connessioneDB.php');

    // Controllo parametri in ingresso
    if (!isset($_POST['nomemateriale'])) {
        err('Parametri per query mancanti', __LINE__);
    }

    // Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    try {
        $query = $db -> prepare('INSERT INTO  techseum.materiali(codmateriale,nomemateriale) VALUES (NULL, :nomemateriale)');
        $query -> bindValue(':nomemateriale', $_POST['nomemateriale']); 
        $query -> execute();

        // Output dell'API in formato JSON
        echo '{"status":1, "data":"Materiale aggiunto al database"}';
        exit();

    } catch(PDOException $ex) {
        err("Errore nell'esecuzione della query", __LINE__);
    }