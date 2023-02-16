<?php

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

if(!isset($_POST['nomeautore'])) {
    err('nome autore mancanti', __LINE__);
}


// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try{
    $query = $db -> prepare('INSERT INTO techseum.autore(nomeautore, annonascita,annofine) VALUES (:nomeautore, :annonascita, :annofine);'); // PDO
    $query -> bindValue(':nomeautore', $_POST['nomeautore']); 
    $query -> bindValue(':annonascita', $_POST['annonascita']);  // --> Fare md5 da SvelteKIT
    $query -> bindValue(':annofine', $_POST['annofine']); 
    $query -> execute();

    echo '{"status":1, "data":"autore creato"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}