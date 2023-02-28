<?php
    // API PER LA L'ESTRAZIONE DI UN IMMAGINE

    // Header per abilitare la richiesta alla API
    header('Access-Control-Allow-Origin: *');

    // Recupera il nome del file dalla richiesta GET
    // $file = __DIR__.'/../immagine/uploads/'. $_GET["path"];

    $file = "/Users/anto/devilbox/data/www/techseum/htdocs/res/miniature/min_" . $_GET["path"];

    // Verifica se il file esiste
    if (file_exists($file)) {

        // Imposta l'header per indicare il tipo di file
        header('Content-Type: image/jpg');
        header('Content-Length: ' . filesize($file));

        // Invia il file al client
        readfile($file);
    }

    else {
        echo '{"status":0, "data":"Impossibile ottenere l\'immagine richiesta"}';
    }