<?php
// API PER L'AGGIORNAMENTO DI UNA MISURA SUL DATABASE

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');


// Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["nomemisura"] $credenziali["unitadimisura"] $credenziali["tipomisura"] 
//$credenziali = json_decode(file_get_contents('php://input'), true);

//Controllo parametri in ingresso
if(!isset($_POST['nomemisura']) or !isset($_POST['unitadimisura']) or !isset($_POST['tipomisura'])) {
    err('Parametri per query mancanti', __LINE__);
}

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try{
    $query = $db -> prepare('UPDATE techseum.nomimisure SET nomemisura=:nomemisura,unitadimisura=:unitadimisura WHERE tipomisura=:tipomisura;'); 
    $query -> bindValue(':tipomisura', $_POST['tipomisura']); 
    $query -> bindValue(':nomemisura', $_POST['nomemisura']); 
    $query -> bindValue(':unitadimisura', $_POST['unitadimisura']); 
    $query -> execute();
  
    // Output dell'API in formato JSON    
    echo '{"status":1, "data":"misura aggiornata"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}