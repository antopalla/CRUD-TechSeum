<?php
//API PER L'AGGIORNAMENTO DI UN UTENTE SUL DATABASE

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');


// Per richieste tramite JSON e non tramite FORM utilizzare, in seguito al decommento della seguente riga, $credenziali["username"] $credenziali["password"] $credenziali["nome"] $credenziali["cognome"] $credenziali["amministratore]
// $credenziali = json_decode(file_get_contents('php://input'), true);

// Controllo parametri in ingresso
if (!isset($_POST['username']) or !isset($_POST['password'])or !isset($_POST['nome'])or !isset($_POST['cognome'])) {
    err('Parametri per query mancanti', __LINE__);
}

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try{
    $query = $db -> prepare('UPDATE techseum.utenti SET utenti.username=:username, utenti.password=:password, utenti.nome=:nome, utenti.cognome=:cognome ,utenti.amministratore=:amministratore WHERE utenti.codutente=:codutente;'); 
    $query -> bindValue(':username', $_POST['username']); 
    $query -> bindValue(':password', $_POST['password']); // --> Fare md5 da SvelteKIT
    $query -> bindValue(':nome', $_POST['nome']); 
    $query -> bindValue(':cognome', $_POST['cognome']); 
    $query -> bindValue(':amministratore', $_POST['amministratore']); 
    $query -> bindValue(':codutente', $_POST['codutente']); 
    $query -> execute();

    // Output dell'API in formato JSON
    echo '{"status":1, "data":"Utente aggiornato"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}