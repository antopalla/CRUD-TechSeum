<?php
// API PER L'ESTRAZIONE DI UN REPERTO DAL DATABASE

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try {
    $query_repertinuova = $db -> prepare('SELECT * FROM techseum.repertinuova WHERE codassoluto=:codassoluto LIMIT 1'); // PDO
    $query_repertinuova -> bindValue(':codassoluto', $_POST['codassoluto']);

    // Query per estrarre tutti gli altri valori collegati al reperto, se sono necessari decommentarli
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
    
    // $query_acquisizioni = $db -> prepare('SELECT tipoacquisizione, dasogPOSTto, quantita FROM techseum.acquisizioni WHERE codassoluto=:codassoluto LIMIT 1'); // PDO
    // $query_acquisizioni -> bindValue(':codassoluto', $_POST['codassoluto']);

    // $query_parti = $db -> prepare('SELECT nomeparte FROM techseum.parti WHERE codassoluto=:codassoluto LIMIT 1'); // PDO
    // $query_parti -> bindValue(':codassoluto', $_POST['codassoluto']);

    $query_repertinuova -> execute();

    //Esecuzione delle query di tutti gli altri valori collegati al reperto, se necessario decommentarli

    // $query_materiali -> execute();

    // $query_didascalie -> execute();

    // $query_misure -> execute();

    // $query_autore -> execute();

    // $query_media -> execute();

    // $query_acquisizioni -> execute();

    // $query_parti -> execute();

    $righe_tabella=$query_repertinuova -> fetchAll();

    //Fetch delle query di tutti gli altri valori collegati al reperto, se necessario documentarli

    //$righe_tabella_materiali=$query_materiali -> fetchAll();

    //$righe_tabella_didascalie=$query_didascalie -> fetchAll();

    //$righe_tabella_misure=$query_misure -> fetchAll();

    //$righe_tabella_autore=$query_autore -> fetchAll();

    //$righe_tabella_media=$query_media -> fetchAll();

    //$righe_tabella_acquisizioni=$query_acquisizioni -> fetchAll()

    //$righe_tabella_parti=$query_parti -> fetchAll();

    // Conversione in JSON e poi da trasformazione del "codassoluto" ad "id" come indice della colonna SQL
    $output_repertinuova = json_encode($righe_tabella_repertinuova);//.$righe_tabella_materiali.$righe_tabella_didascalie.$righe_tabella_misure.$righe_tabella_autore.$righe_tabella_media.$righe_tabella_acquisizioni.$righe_tabella_parti);
    $output_repertinuova = str_replace("codassoluto", "id", $output_repertinuova);

    //Conversione in JSON di tutti i fetch degli altri valori collegati al reperto, se necessario decommentarli

    //$output_materiali = json_encode($righe_tabella_materiali);//.$righe_tabella_materiali.$righe_tabella_didascalie.$righe_tabella_misure.$righe_tabella_autore.$righe_tabella_media.$righe_tabella_acquisizioni.$righe_tabella_parti);
    //$output_materiali = str_replace("codassoluto", "id", $output_materiali);

    //$output_didascalie = json_encode($righe_tabella_didascalie);//.$righe_tabella_materiali.$righe_tabella_didascalie.$righe_tabella_misure.$righe_tabella_autore.$righe_tabella_media.$righe_tabella_acquisizioni.$righe_tabella_parti);
    //$output_didascalie = str_replace("codassoluto", "id", $output_didascalie);

    //$output_misure = json_encode($righe_tabella_misure);//.$righe_tabella_materiali.$righe_tabella_didascalie.$righe_tabella_misure.$righe_tabella_autore.$righe_tabella_media.$righe_tabella_acquisizioni.$righe_tabella_parti);
    //$output_misure = str_replace("codassoluto", "id", $output_misure);

    //$output_autore = json_encode($righe_tabella_autore);//.$righe_tabella_materiali.$righe_tabella_didascalie.$righe_tabella_misure.$righe_tabella_autore.$righe_tabella_media.$righe_tabella_acquisizioni.$righe_tabella_parti);
    //$output_autore = str_replace("codassoluto", "id", $output_autore);

    //$output_media = json_encode($righe_tabella_media);//.$righe_tabella_materiali.$righe_tabella_didascalie.$righe_tabella_misure.$righe_tabella_autore.$righe_tabella_media.$righe_tabella_acquisizioni.$righe_tabella_parti);
    //$output_media = str_replace("codassoluto", "id", $output_media);

    //$output_acquisizioni = json_encode($righe_tabella_acquisizioni);//.$righe_tabella_materiali.$righe_tabella_didascalie.$righe_tabella_misure.$righe_tabella_autore.$righe_tabella_media.$righe_tabella_acquisizioni.$righe_tabella_parti);
    //$output_acquisizioni = str_replace("codassoluto", "id", $output_acquisizioni);

    //$output_parti = json_encode($righe_tabella_parti);//.$righe_tabella_materiali.$righe_tabella_didascalie.$righe_tabella_misure.$righe_tabella_autore.$righe_tabella_media.$righe_tabella_acquisizioni.$righe_tabella_parti);
    //$output_parti = str_replace("codassoluto", "id", $output_parti);

    //Concatenazione in un'unica stringa di tutti i JSON, se necessario decommentarli
    $output=strval($output_repertinuova);//.strval($output_materiali).strval($output_didascalie).strval($output_misure).strval($output_autore).strval($output_media).strval($output_acquisizioni).strval($output_parti);
    
    // Output dell'API in formato JSON
    echo '{"status":1, "data":'.$output.'}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}