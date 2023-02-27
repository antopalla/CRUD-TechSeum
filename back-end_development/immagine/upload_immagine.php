<?php
// API PER LA L'UPLOAD DI UN IMMAGINE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');

    $target_dir = __DIR__.'/../immagine/uploads/'; // specifica la directory di destinazione per i file caricati
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); // ottieni il nome del file caricato
    $uploadOk = 1; // impostiamo un flag a 1 per indicare che il caricamento è andato a buon fine

    // controlliamo se il file esiste già nella directory di destinazione
    if (file_exists($target_file)) {
        echo '{"status":0, "data":"Il file esiste già"}';
        $uploadOk = 0;
    }

    // controlliamo se il file è troppo grande
    if ($_FILES["fileToUpload"]["size"] > 25000000) {
        echo '{"status":0, "data":"Il file è troppo grande"}';
        $uploadOk = 0;
    }

    // consentiamo solo determinati formati di file
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    $fileExtension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if(!in_array($fileExtension, $allowedExtensions)) {
        echo '{"status":0, "data":"Sono consentiti solo file JPG, JPEG, PNG e GIF"}';
        $uploadOk = 0;
    }

    // controlliamo se $uploadOk è impostato su 0 a causa di un errore
    if ($uploadOk == 0) {
        echo '{"status":0, "data":"Il file non è stato caricato"}';
    // se tutto va bene, proviamo a caricare il file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo '{"status":1, "data":"Il file '. basename( $_FILES["fileToUpload"]["name"]). ' è stato caricato."}';
        } else {
            echo '{"status":0, "data":"Si è verificato un errore durante il caricamento del file"}';
        }
    }
?>
