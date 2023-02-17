<?php
// API PER LA LA RIMOZIONE DI UN MATERIALE DAL DATABASE

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["codmateriale"] 
//$credenziali = json_decode(file_get_contents('php://input'), true);

// Controllo parametri in ingresso
if (!isset($_POST['codmateriale'])) {
    err('Parametri per query mancanti', __LINE__); 
}

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try {
    $query = $db -> prepare('DELETE FROM techseum.materiali WHERE codmateriale=:codmateriale');
    $query -> bindValue(':codmateriale', $_POST['codmateriale']); 
    $query -> execute();
  
    // Output dell'API in formato JSON
    echo '{"status":1, "data":"Materiale rimosso dal database"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}