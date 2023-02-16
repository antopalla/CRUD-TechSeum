<?php
// API PER LA L'AGGIORNAMENTO DI UN AUTORE DAL DATABASE

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["nomeautore"] $credenziali["annonascita"] $credenziali["annofine"] $credenziali["codautore"]
// $credenziali = json_decode(file_get_contents('php://input'), true);

// Controllo parametri in ingresso
if(!isset($_POST['codautore'])) {
    err('Parametri per query mancanti', __LINE__);
}

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try{
    $query = $db -> prepare('UPDATE techseum.autore SET autore.nomeautore=:nomeautore, autore.annonascita=:annonascita, autore.annofine=:annofine WHERE autore.codautore=:codautore;');
    $query -> bindValue(':nomeautore', $_POST['nomeautore']); 
    $query -> bindValue(':annonascita', $_POST['annonascita']);
    $query -> bindValue(':annofine', $_POST['annofine']);  
    $query -> bindValue(':codautore', $_POST['codautore']); 
    $query -> execute();
  
    echo '{"status":1, "data":"Autore aggiornato"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}
