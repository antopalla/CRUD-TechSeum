<?php

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');


// Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["username"] $credenziali["password"] $credenziali["nome"] $credenziali["cognome"] $credenziali["amministratore]
//$credenziali = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST['tipomisura'])) {
    err('Non hai inserito qualche dato:', __LINE__);
}
// Utilizzo del try - catch per eventuali errori nella query
try{
    $query = $db -> prepare('DELETE FROM techseum.nomimisure WHERE tipomisura=:tipomisura'); // PDO
    $query -> bindValue(':tipomisura', $_POST['tipomisura']); // NO SQL INJECTION
    $query -> execute();
  
    echo '{"status":1, "data":"misura eliminata"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}