<?php
// API PER L'ESTRAZIONE DEGLI UTENTI DEL DATABASE

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Utilizzo del try - catch per eventuali errori nella query
try {
    $query = $db -> prepare('SELECT codutente, username, nome, cognome, amministratore FROM techseum.utenti'); 
    $query -> execute();
    $righe_tabella = $query -> fetchAll();
       
    // Conversione in JSON e poi da trasformazione del "codutente" ad "id" come indice della colonna SQL
    $output = json_encode($righe_tabella);
    $output = str_replace("codutente", "id", $output);

    // Output dell'API in formato JSON
    echo '{"status":1, "data":'.$output.'}';
    exit();

    } catch(PDOException $ex){
        err("Errore nell'esecuzione della query", __LINE__);
}



