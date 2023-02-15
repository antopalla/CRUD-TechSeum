<?php

try {
    $dbUserName = 'root';
    $dbPassword = '';
    $dbConnection = 'mysql:host=127.0.0.1; dbname=techseum; charset = utf8';
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