<?php
    // CONNESSIONE AL DATABASE
    
    require_once(__DIR__.'/const.php');

    try {
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // per utilizzare try-catch in ogni query sql   
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC    // per convertire l'array associativo derivante dalla query in JSON con facilità
    ];
    $db = new PDO(  $dbConnection,
                    $dbUserName,
                    $dbPassword,
                    $options );

    } catch(PDOException $ex) {
        echo '{
                "status: 0, 
                "message":"Impossibile stabilire la connessione al database.",
                "debug":'.__LINE__.'
            }';
        exit();
    }