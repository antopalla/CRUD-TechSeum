<?php
    // API PER LA L'UPLOAD DI UN IMMAGINE

    namespace Verot\Upload;
    include('./class.upload.php');
    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/const.php');

    $foo = new Upload($_FILES['file']); 
    $sezione = $_POST['sezione'];
    $codrelativo = $_POST['codrelativo'];
    $numero = $_POST['numero'];
    $nomeFile = $sezione."-".$codrelativo.".".$numero;

    if ($foo->uploaded) {
        // Salva l'immagine caricata con un nuovo nome
        $foo->file_new_name_body = $nomeFile;
        $foo->process($dirImmagini);
        if ($foo->processed) {
            echo '{"status":1, "data":"Il file '. $nomeFile . ' è stato caricato."}';
        } else {
            '{"status":1, "data":"Errore: '. $foo->error . '"}';
        }

        // Salva la miniatura dopo aver fatto il resize
        $foo->file_new_name_body = "min_" . $nomeFile;
        $foo->image_resize = true;
        $foo->image_convert = 'jpg';
        $foo->image_x = 150;
        $foo->image_ratio_y = true;
        $foo->process($dirMiniature);
        if ($foo->processed) {
            echo '{"status":1, "data":"Il file '. $nomeFile . ' è stato caricato."}';
            $foo->clean();
        } else {
            echo'{"status":1, "data":"Errore: '. $foo->error . '"}';
        } 
    }  