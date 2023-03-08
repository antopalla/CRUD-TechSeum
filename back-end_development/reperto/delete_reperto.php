<?php
    // API PER LA RIMOZIONE DI UN REPERTO DAL DATABASE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/connessioneDB.php');

    // Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    try {
        // Query per l'eliminazione completa del record da tutte le tabelle del database
        $query_repertinuova = $db -> prepare('DELETE FROM techseum.repertinuova WHERE :codassoluto=codassoluto;'); 
        $query_hafatto = $db -> prepare('DELETE FROM techseum.hafatto WHERE :codassoluto=codassoluto;'); 
        $query_misure = $db -> prepare('DELETE FROM techseum.misure WHERE :codassoluto=codassoluto;'); 
        $query_didascalie = $db -> prepare('DELETE FROM techseum.didascalie WHERE :codassoluto=codassoluto;');
        $query_media = $db -> prepare('DELETE FROM techseum.media WHERE :codassoluto=codassoluto;'); 
        $query_acquisizioni = $db -> prepare('DELETE FROM techseum.acquisizioni WHERE :codassoluto=codassoluto;'); 
        $query_parti = $db -> prepare('DELETE FROM techseum.parti WHERE :codassoluto=codassoluto;');
        $query_compostoda = $db -> prepare('DELETE FROM techseum.compostoda WHERE :codassoluto=codassoluto;'); 

        $query_repertinuova -> bindValue(':codassoluto', $_POST['codassoluto']); 
        $query_hafatto -> bindValue(':codassoluto', $_POST['codassoluto']); 
        $query_misure -> bindValue(':codassoluto', $_POST['codassoluto']); 
        $query_didascalie -> bindValue(':codassoluto', $_POST['codassoluto']);
        $query_media -> bindValue(':codassoluto', $_POST['codassoluto']);
        $query_acquisizioni -> bindValue(':codassoluto', $_POST['codassoluto']);
        $query_parti -> bindValue(':codassoluto', $_POST['codassoluto']);
        $query_compostoda -> bindValue(':codassoluto', $_POST['codassoluto']);

        $query_repertinuova -> execute();
        $query_hafatto -> execute();
        $query_misure -> execute();
        $query_didascalie -> execute();
        $query_media -> execute();
        $query_acquisizioni -> execute();
        $query_parti -> execute();
        $query_compostoda -> execute();

        // Output dell'API in formato JSON    
        echo '{"status":1, "message":"reperto deleted"}';
        exit();

    } catch(PDOException $ex) {
        err("Errore nell'esecuzione della query", __LINE__);
    }

