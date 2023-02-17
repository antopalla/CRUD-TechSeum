<?php
// API PER L'ESTRAZIONE DI UNA MISURA

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["tipomisura"] 
//$credenziali = json_decode(file_get_contents('php://input'), true);

//Controllo parametri in ingresso
if(!isset($_POST['tipomisura'])) {
    err('Parametri per query mancanti', __LINE__);
}

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try{
    $query = $db -> prepare('SELECT * FROM techseum.nomimisure WHERE tipomisura=:tipomisura;'); 
    $query -> bindValue(':tipomisura', $_POST['tipomisura']); 
    $query -> execute();
    $righe_tabella = $query -> fetchAll();
  
    // Output dell'API in formato JSON
    echo '{"status":1, "data":'.json_encode($righe_tabella).'}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}