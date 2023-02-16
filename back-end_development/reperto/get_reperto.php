<?php
require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');
// Utilizzo del try - catch per eventuali errori nella query
try {
    $query_repertinuova = $db -> prepare('SELECT * FROM techseum.repertinuova WHERE codassoluto=:codassoluto LIMIT 1'); // PDO
    $query_repertinuova -> bindValue(':codassoluto', $_GET['codassoluto']);

    // $query_materiali = $db -> prepare('SELECT nomemateriale FROM techseum.materiali, techseum.compostoda WHERE codassoluto=:codassoluto AND codmateriale=:codmateriale LIMIT 1'); // PDO
    // $query_materiali -> bindValue(':codassoluto', $_POST['codassoluto']);
    // $query_materiali -> bindValue(':codmateriale', $_POST['codmateriale']);

    // $query_didascalie = $db -> prepare('SELECT didascalia FROM techseum.didascalie WHERE codassoluto=:codassoluto LIMIT 1'); // PDO
    // $query_didascalie -> bindValue(':codassoluto', $_POST['codassoluto']);

    // $query_misure = $db -> prepare('SELECT tipomisura, valore FROM techseum.misure WHERE codassoluto=:codassoluto LIMIT 1'); // PDO
    // $query_misure -> bindValue(':codassoluto', $_POST['codassoluto']);

    // $query_autore = $db -> prepare('SELECT nomeautore, annonascita, annofine FROM techseum.hafatto, techseum.autore WHERE codassoluto=:codassoluto AND codautore=:codautore LIMIT 1'); // PDO
    // $query_autore -> bindValue(':codassoluto', $_POST['codassoluto']);
    // $query_autore -> bindValue(':codautore', $_POST['codautore']);

    // $query_media = $db -> prepare('SELECT link, fonte FROM techseum.media WHERE codassoluto=:codassoluto LIMIT 1'); // PDO
    // $query_media -> bindValue(':codassoluto', $_POST['codassoluto']);
    
    // $query_acquisizioni = $db -> prepare('SELECT tipoacquisizione, dasoggetto, quantita FROM techseum.acquisizioni WHERE codassoluto=:codassoluto LIMIT 1'); // PDO
    // $query_acquisizioni -> bindValue(':codassoluto', $_POST['codassoluto']);

    // $query_parti = $db -> prepare('SELECT nomeparte FROM techseum.parti WHERE codassoluto=:codassoluto LIMIT 1'); // PDO
    // $query_parti -> bindValue(':codassoluto', $_POST['codassoluto']);
    $query_repertinuova -> execute();
    // $query_materiali -> execute();
    // $query_didascalie -> execute();
    // $query_misure -> execute();
    // $query_autore -> execute();
    // $query_media -> execute();
    // $query_acquisizioni -> execute();
    // $query_parti -> execute();
    $righe_tabella=$query_repertinuova -> fetchAll();
    // Conversione in JSON e poi da trasformazione del "codassoluto" ad "id" come indice della colonna SQL
    $output = json_encode($righe_tabella);
    $output = str_replace("codassoluto", "id", $output);
    // Output dell'API in formato JSON
    echo '{"status":1, "data":'.$output.'}';
    exit();
} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", _LINE_);
}

