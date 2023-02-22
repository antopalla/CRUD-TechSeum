<?php
// API PER L'ELIMINAZIONE DI UN UTENTE DAL DATABASE

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["username"] $credenziali["password"] $credenziali["nome"] $credenziali["cognome"] $credenziali["amministratore]
// $credenziali = json_decode(file_get_contents('php://input'), true);

// Controllo parametri in ingresso
if(!isset($_GET['codutente'])) {
    err('Parametri per query mancanti', __LINE__);
}

/// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try {
    $query = $db -> prepare('DELETE FROM techseum.utenti WHERE codutente=:codutente;');
    $query -> bindValue(':codutente', $_GET['codutente']); 
    $query -> execute();
  
    // Output dell'API in formato JSON
    echo '{"status":1, "data":"Utente rimosso dal database"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}