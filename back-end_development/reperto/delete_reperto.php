<?php
require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Header per indicare che le richieste HTTP sono in formato JSON
header('Content-Type: application/json');

// Sessione e controllo login
// Connessione al database (require_once = sostituisce la riga di codice con il codice contenuto nel file al path)

try{
    $query_repertinuova = $db -> prepare('DELETE FROM techseum.repertinuova WHERE :codassoluto=codassoluto;'); // QUERY DI DELETE RECORD
    $query_hafatto = $db -> prepare('DELETE FROM techseum.hafatto WHERE :codassoluto=codassoluto;'); // QUERY DI DELETE RECORD
    $query_misure = $db -> prepare('DELETE FROM techseum.misure WHERE :codassoluto=codassoluto;'); // QUERY DI DELETE RECORD
    $query_didascalie = $db -> prepare('DELETE FROM techseum.didascalie WHERE :codassoluto=codassoluto;'); // QUERY DI DELETE RECORD
    $query_media = $db -> prepare('DELETE FROM techseum.media WHERE :codassoluto=codassoluto;'); // QUERY DI DELETE RECORD
    $query_acquisizioni = $db -> prepare('DELETE FROM techseum.acquisizioni WHERE :codassoluto=codassoluto;'); // QUERY DI DELETE RECORD
    $query_parti = $db -> prepare('DELETE FROM techseum.parti WHERE :codassoluto=codassoluto;'); // QUERY DI DELETE RECORD
    $query_comGEToda = $db -> prepare('DELETE FROM techseum.comGEToda WHERE :codassoluto=codassoluto;'); // QUERY DI DELETE RECORD

    $query_repertinuova -> bindValue(':codassoluto', $_GET['codassoluto']); // NO SQL INJECTION
    $query_hafatto -> bindValue(':codassoluto', $_GET['codassoluto']); // NO SQL INJECTION
    $query_misure -> bindValue(':codassoluto', $_GET['codassoluto']); // NO SQL INJECTION
    $query_didascalie -> bindValue(':codassoluto', $_GET['codassoluto']); // NO SQL INJECTION
    $query_media -> bindValue(':codassoluto', $_GET['codassoluto']); // NO SQL INJECTION
    $query_acquisizioni -> bindValue(':codassoluto', $_GET['codassoluto']); // NO SQL INJECTION
    $query_parti -> bindValue(':codassoluto', $_GET['codassoluto']); // NO SQL INJECTION
    $query_comGEToda -> bindValue(':codassoluto', $_GET['codassoluto']); // NO SQL INJECTION

    $query_repertinuova -> execute();
    $query_hafatto -> execute();
    $query_misure -> execute();
    $query_didascalie -> execute();
    $query_media -> execute();
    $query_acquisizioni -> execute();
    $query_parti -> execute();
    $query_comGEToda -> execute();
    echo '{"status":1, "message":"reperto deleted"}';
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
echo '{"status":1, "message":"reperto deleted"}';

