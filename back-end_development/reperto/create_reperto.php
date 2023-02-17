<?php
// API PER L'AGGIUNTA DI UN REPERTO AL DATABASE

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Per richieste tramite JSON e non tramite FORM utilizzare
//$credenziali = json_decode(file_get_contents('php://input'), true);

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try{
    $query = $db -> prepare('INSERT INTO techseum.repertinuova (datacatalogazione, nome, sezione, codrelativo, definizione, denominazionestorica, descrizione, modouso, annoiniziouso, annofineuso, scopo, stato, osservazioni) VALUES (:datacatalogazione, :nome, :sezione, :codrelativo, :definizione, :denominazionestorica, :descrizione, :modouso, :annoiniziouso, :annofineuso, :scopo, :stato, :osservazioni);'); 
    $query -> bindValue(':datacatalogazione', $_GET['datacatalogazione']); 
    $query -> bindValue(':nome', $_GET['nome']); 
    $query -> bindValue(':sezione', $_GET['sezione']); 
    $query -> bindValue(':codrelativo', $_GET['codrelativo']); 
    $query -> bindValue(':definizione', $_GET['definizione']); 
    $query -> bindValue(':denominazionestorica', $_GET['denominazionestorica']);
    $query -> bindValue(':descrizione', $_GET['descrizione']); 
    $query -> bindValue(':modouso', $_GET['modouso']); 
    $query -> bindValue(':annoiniziouso', $_GET['annoiniziouso']); 
    $query -> bindValue(':annofineuso', $_GET['annofineuso']); 
    $query -> bindValue(':scopo', $_GET['scopo']);
    $query -> bindValue(':stato', $_GET['stato']); 
    $query -> bindValue(':osservazioni', $_GET['osservazioni']);   
    $query -> execute();
    $quert = $db -> prepare('SELECT codassoluto FROM techseum.repertinuova order by codassoluto desc limit 1;'); 
    $quert -> execute();
    $codas= $quert -> fetchAll();
    $codassoluto=$codas[0]['codassoluto'];
    $querion = $db -> prepare('INSERT INTO techseum.hafatto(codassoluto,codautore) VALUES (:codassoluto,:codautore);');
    $querion -> bindValue(':codassoluto', $codassoluto);
    $querion -> bindValue(':codautore', $_GET['codautore']);
    $querion -> execute();

    // Output dell'API in formato JSON
    echo '{"status":1, "message":"reperto created"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}


