<?php

// Header per indicare che le richieste HTTP sono in formato JSON
header('Content-Type: application/json');

// Connessione al database (require_once = sostituisce la riga di codice con il codice contenuto nel file al path)
require_once(__DIR__.'/protected/database.php');

echo '{"status":1, "message":"reperto created"}';