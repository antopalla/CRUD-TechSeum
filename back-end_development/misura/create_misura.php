<?php
//API PER L'AGGIUNTA DI UNA MISURA AL DATABASE

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["nomemisura"] $credenziali["unitadimisura"] $credenziali["tipomisura"]
//$credenziali = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST['nomemisura']) or !isset($_POST['unitadimisura']) or !isset($_POST['tipomisura'])) {
    err('Parametri per query mancanti', __LINE__);
}


// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try{
    $query = $db -> prepare('INSERT INTO nomimisure(tipomisura,nomemisura,unitadimisura) VALUES (:tipomisura,:nomemisura,:unitadimisura);'); // PDO
    $query -> bindValue(':tipomisura', $_POST['tipomisura']);
    $query -> bindValue(':nomemisura', $_POST['nomemisura']); 
    $query -> bindValue(':unitadimisura', $_POST['unitadimisura']);
    $query -> execute();
  
    // Output dell'API in formato JSON
    echo '{"status":1, "data":"nuova unità di misura creata"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}