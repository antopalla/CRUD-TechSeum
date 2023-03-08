<?php
    // API PER LA L'ESTRAZIONE DI UN IMMAGINE
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/const.php');

    // Header per abilitare la richiesta alla API
    header('Access-Control-Allow-Origin: *');

    // Recupera il nome del file dalla richiesta GET
    $ext = strtolower(substr($_GET["path"], strrpos($_GET["path"], '.') + 1));
    $nomefile = str_ireplace("." . $ext, "." . $ext, $_GET["path"]);

    // Genera path miniatura
    $file = $dirMiniature . "min_" . $nomefile;

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