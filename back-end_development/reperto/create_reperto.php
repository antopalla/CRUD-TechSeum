<?php
require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');


// Utilizzo del try - catch per eventuali errori nella query
try{
    $query = $db -> prepare('INSERT INTO techseum.repertinuova (datacatalogazione, nome, sezione, codrelativo, definizione, denominazionestorica, descrizione, modouso, annoiniziouso, annofineuso, scopo, stato, osservazioni) VALUES (:datacatalogazione, :nome, :sezione, :codrelativo, :definizione, :denominazionestorica, :descrizione, :modouso, :annoiniziouso, :annofineuso, :scopo, :stato, :osservazioni);'); // PDO
    $query -> bindValue(':datacatalogazione', $_GET['datacatalogazione']); // NO SQL INJECTION
    $query -> bindValue(':nome', $_GET['nome']); // NO SQL INJECTION
    $query -> bindValue(':sezione', $_GET['sezione']); // NO SQL INJECTION
    $query -> bindValue(':codrelativo', $_GET['codrelativo']); // NO SQL INJECTION
    $query -> bindValue(':definizione', $_GET['definizione']); // NO SQL INJECTION
    $query -> bindValue(':denominazionestorica', $_GET['denominazionestorica']); // NO SQL INJECTION
    $query -> bindValue(':descrizione', $_GET['descrizione']); // NO SQL INJECTION
    $query -> bindValue(':modouso', $_GET['modouso']); // NO SQL INJECTION
    $query -> bindValue(':annoiniziouso', $_GET['annoiniziouso']); // NO SQL INJECTION
    $query -> bindValue(':annofineuso', $_GET['annofineuso']); // NO SQL INJECTION
    $query -> bindValue(':scopo', $_GET['scopo']); // NO SQL INJECTION
    $query -> bindValue(':stato', $_GET['stato']); // NO SQL INJECTION
    $query -> bindValue(':osservazioni', $_GET['osservazioni']); // NO SQL INJECTION    
    $query -> execute();
    $quert = $db -> prepare('SELECT codassoluto FROM techseum.repertinuova order by codassoluto desc limit 1;'); // PDO
    $quert -> execute();
    $codas= $quert -> fetchAll();
    $codassoluto=$codas[0]['codassoluto'];
    $querion = $db -> prepare('INSERT INTO techseum.hafatto(codassoluto,codautore) VALUES (:codassoluto,:codautore);');
    $querion -> bindValue(':codassoluto', $codassoluto);
    $querion -> bindValue(':codautore', $_GET['codautore']); // NO SQL INJECTION
    $querion -> execute();
    echo '{"status":1, "message":"reperto created"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}


