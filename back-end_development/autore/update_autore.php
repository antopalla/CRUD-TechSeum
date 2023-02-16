<?php

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');


// Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["username"] $credenziali["password"] $credenziali["nome"] $credenziali["cognome"] $credenziali["amministratore]
// $credenziali = json_decode(file_get_contents('php://input'), true);

//controllo per vedere se l'utente ha inserito i vari campi
if(!isset($_POST['nomeautore']) ) {
    err('nomeautore mancanti', __LINE__);
}

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try{
    $query = $db -> prepare('UPDATE techseum.autore SET autore.nomeautore=:nomeautore, autore.annonascita=:annonascita, autore.annofine=:annofine WHERE autore.codautore=:codautore;'); // PDO
    $query -> bindValue(':nomeautore', $_POST['nomeautore']); 
    $query -> bindValue(':annonascita', $_POST['annonascita']); // --> Fare md5 da SvelteKIT
    $query -> bindValue(':annofine', $_POST['annofine']);  
    $query -> bindValue(':codautore', $_POST['codautore']); 
    $query -> execute();
  
    echo '{"status":1, "data":"autore modificata"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}

//////p1