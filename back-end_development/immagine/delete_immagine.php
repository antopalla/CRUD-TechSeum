<?php

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');

    $filename = __DIR__.'/../immagine/uploads/'.$_GET["path"]; 

    if (file_exists($filename)) { // verifica se il file esiste
        if (unlink($filename)) { // rimuovi il file
            echo '{"status":1, "data":"File eliminato con successo."}';
        } 
        else {
            echo '{"status":0, "data":"Impossibile eliminare il file."}';
        }
    }
    else {
        echo '{"status":0, "data":"Il file che stai tentando di eliminare non esiste."}';
    }