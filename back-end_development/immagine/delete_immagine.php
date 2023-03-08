<?php
    // API PER LA L'ELIMINAZIONE DI UN IMMAGINE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/const.php');

    // Variabili per la gestione dei nomi dei file
    $filename_min = $dirMiniature . "min_" . $_GET["path"];
    $filename_img = $dirImmagini . $_GET["path"];

    if (file_exists($filename_min)) {   // Controlla se il file esiste
        if (unlink($filename_min)) {    // Rimuovi la miniatura
            unlink($filename_img);      // Se la miniatura è stata rimossa, rimuovi anche l'immagine originale
            echo '{"status":1, "data":"File eliminato con successo."}';
        } 
        else {
            echo '{"status":0, "data":"Impossibile eliminare il file."}';
        }
    }
    else {
        echo '{"status":0, "data":"Il file che stai tentando di eliminare non esiste."}';
    }