<?php

    require_once(__DIR__.'/protected/headers.php');
    require_once(__DIR__.'/protected/functions.php');
    require_once(__DIR__.'/protected/connessioneDB.php');

    // Inizio della sessione
    session_start();

    // Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["username"] $credenziali["password"]
    //$credenziali = json_decode(file_get_contents('php://input'), true);

    // Controllo presenza username e password nel metodo POST
    if(!isset($_POST['username']) or !isset($_POST['password'])) {
        err('Username o password mancanti', __LINE__);
    }

    // Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    try{
        $query = $db -> prepare('SELECT * FROM techseum.utenti WHERE username = :username and password = :password LIMIT 1'); // PDO
        $query -> bindValue(':username', $_POST['username']); 
        $query -> bindValue(':password', $_POST['password']);
        $query -> execute();
        $righe_tabella = $query -> fetchAll();

        if(!$righe_tabella) {
            err("Username o password errati", 404);
            exit();
        }

        // Conversione in JSON e poi da trasformazione del "codassoluto" ad "id" come indice della colonna SQL
        $output = json_encode($righe_tabella);
        $output = str_replace("codutente", "id", $output);

        // Output dell'API in formato JSON
        echo '{"status":1, "data":'.$output.'}';

        // Impostiamo l'utente come loggato e se amministratore
        $_SESSION["loggedIn"] = true;

        if ($righe_tabella[0]["amministratore"]==1) {
            $_SESSION["amministratore"] = true;
        }
        else {
            $_SESSION["amministratore"] = false;
        }
        
        exit();

    } catch(PDOException $ex) {
        err("Errore nell'esecuzione della query", __LINE__);
    }
