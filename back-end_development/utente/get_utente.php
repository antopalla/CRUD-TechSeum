<?php

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

/// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try {
    $query = $db -> prepare('SELECT username,nome,cognome,amministratore FROM techseum.utenti where codutente=:codutente LIMIT 1'); // PDO
    $query -> bindValue(':codutente', $_POST['codutente']);
    $query -> execute();
    $righe_tabella = $query -> fetchAll();

    // Output dell'API in formato JSON
    echo '{"status":1, "data":'.json_encode($righe_tabella).'}';
    exit();

    } catch(PDOException $ex){
        err("Errore nell'esecuzione della query", __LINE__);
}

