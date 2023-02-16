<?php

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["username"] $credenziali["password"] $credenziali["nome"] $credenziali["cognome"] $credenziali["amministratore]
//$credenziali = json_decode(file_get_contents('php://input'), true);

// Utilizzo del try - catch per eventuali errori nella query
try{
    $query = $db -> prepare('SELECT * FROM techseum.nomimisure;'); // PDO
    $query -> execute();
    $righe_tabella = $query -> fetchAll();
  
    echo '{"status":1, "data":'.json_encode($righe_tabella).'}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}