<?php
// Header per indicare che le richieste HTTP sono in formato JSON
header('Content-Type: application/json');

// Sessione e controllo login
session_start();
if (!$_SESSION["loggedIn"]) {
    header("Location: xxxxx"); // --> Inserire link della pagine di login
    die;
}

require_once(__DIR__.'/protected/headers.php');
require_once(__DIR__.'/protected/functions.php');
require_once(__DIR__.'/protected/check_session.php');
require_once(__DIR__.'/protected/connessioneDB.php');


// Utilizzo del try - catch per eventuali errori nella query
try{
    $query = $db -> prepare('INSERT INTO techseum.repertinuova (datacatalogazione, nome, sezione, codrelativo, definizione, denominazionestorica, descrizione, moduso, annoiniziouso, annofineuso, scopo, stato, osservazioni) VALUES (:datacatalogazione, :nome, :sezione, :codrelativo, :definizione, :denominazionestorica, :descrizione, :moduso, :annoiniziouso, :annofineuso, :scopo, :stato, :osservazioni);'); // PDO
    $query -> bindValue(':datacatalogazione', $_POST['datacatalogazione']); // NO SQL INJECTION
    $query -> bindValue(':nome', $_POST['nome']); // NO SQL INJECTION
    $query -> bindValue(':sezione', $_POST['sezione']); // NO SQL INJECTION
    $query -> bindValue(':codrelativo', $_POST['codrelativo']); // NO SQL INJECTION
    $query -> bindValue(':definizione', $_POST['definizione']); // NO SQL INJECTION
    $query -> bindValue(':denominazionestorica', $_POST['denominzazionestorica']); // NO SQL INJECTION
    $query -> bindValue(':descrizione', $_POST['descrizione']); // NO SQL INJECTION
    $query -> bindValue(':moduso', $_POST['moduso']); // NO SQL INJECTION
    $query -> bindValue(':annoiniziouso', $_POST['annoiniziouso']); // NO SQL INJECTION
    $query -> bindValue(':annofineuso', $_POST['annofineuso']); // NO SQL INJECTION
    $query -> bindValue(':scopo', $_POST['scopo']); // NO SQL INJECTION
    $query -> bindValue(':stato', $_POST['stato']); // NO SQL INJECTION
    $query -> bindValue(':osservazioni', $_POST['osservazioni']); // NO SQL INJECTION
    $query1 = $db -> prepare('INSERT INTO techseum. (codassoluto, datacatalogazione, nome, sezione, codrelativo, definizione, denominazionestorica, descrizione, moduso, annoiniziouso, annofineuso, scopo, stato, osservazioni) VALUES (:codassoluto, :datacatalogazione, :nome, :sezione, :codrelativo, :definizione, :denominazionestorica, :descrizione, :moduso, :annoiniziouso, :annofineuso, :scopo, :stato, :osservazioni);'); // PDO

    $query -> execute();
  
    echo '{"status":1, "message":"reperto created"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}

// Funzione per generare messaggio di errore
function err($message = 'error', $debug = 0) {
    echo '{ "status":0,
            "message":"'.$message.'",
            "debug":'.$debug.'}';
    exit();
}
