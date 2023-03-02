<?php
// API PER LA L'ELIMINAZIONE DI UN IMMAGINE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/const.php');

    $filename_min = $dirMiniature . "min_" . $_GET["path"];
    $filename_img = $dirImmagini . $_GET["path"];

    if (file_exists($filename_min)) { // verifica se il file esiste
        if (unlink($filename_min)) { // rimuovi il file
            unlink($filename_img);
            echo '{"status":1, "data":"File eliminato con successo."}';
        } 
        else {
            echo '{"status":0, "data":"Impossibile eliminare il file."}';
        }
    }
    else {
        echo '{"status":0, "data":"Il file che stai tentando di eliminare non esiste."}';
    }