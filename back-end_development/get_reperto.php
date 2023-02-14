<?php

// Header per indicare che le richieste HTTP sono in formato JSON
header('Content-Type: application/json');

// Sessione e controllo login
/*session_start();
if (!$_SESSION["loggedIn"]) {
    header("Location: xxxxx"); // --> Inserire link della pagine di login
    die;
}*/

// Connessione al database (require_once = sostituisce la riga di codice con il codice contenuto nel file al path)
require_once(__DIR__.'/protected/database.php');

echo '{"status":1, "data":{"id":1, "name":"A"}}';

