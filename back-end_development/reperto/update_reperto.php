<?php
//API PER L'AGGIORNAMENTO DI UN REPERTO SUL DATABASE

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    /*
    QUESTA PARTE MODIFICA LA TABELLA REPERTINUOVA INSERENDO SOLO UN NUOVO NOME AL REPERTO.
    */
try{
    $query = $db -> prepare('UPDATE techseum.repertinuova SET nome=:nome, datacatalogazione=:datacatalogazione, sezione=:sezione, codrelativo=:codrelativo, definizione=:definizione, denominazionestorica=:denominazionestorica, descrizione=:descrizione, modouso=:modouso, annoiniziouso=:annoiniziouso, annofineuso=:annofineuso, scopo=:scopo, stato=:stato, osservazioni=:osservazioni WHERE codassoluto=:codassoluto;');
    $query -> bindValue(':codassoluto', $_GET['codassoluto']); 
    $query -> bindValue(':nome', $_GET['nome']);
    $query -> bindValue(':datacatalogazione', $_GET['datacatalogazione']); 
    $query -> bindValue(':sezione', $_GET['sezione']); 
    $query -> bindValue(':codrelativo', $_GET['codrelativo']); 
    $query -> bindValue(':definizione', $_GET['definizione']); 
    $query -> bindValue(':denominazionestorica', $_GET['denominazionestorica']); 
    $query -> bindValue(':modouso', $_GET['modouso']); 
    $query -> bindValue(':annoiniziouso', $_GET['annoiniziouso']); 
    $query -> bindValue(':annofineuso', $_GET['annofineuso']); 
    $query -> bindValue(':scopo', $_GET['scopo']); 
    $query -> bindValue(':osservazioni', $_GET['osservazioni']); 
    $query -> bindValue(':stato', $_GET['stato']); 
    $query -> bindValue(':definizione', $_GET['definizione']); 
    $query -> bindValue(':descrizione', $_GET['descrizione']); 
    $query -> execute();
    /*
    QUESTA PARTE MODIFICA IL NOME DELL'AUTORE PARTENDO DAL CODICEASSOLUTO 
    */
    
    $queryone = $db -> prepare('UPDATE techseum.hafatto SET codautore=:codautore  WHERE codassoluto=:codassoluto;');
    $queryone -> bindValue(':codautore',$_GET['codautore']);
    $queryone -> bindValue(':codassoluto',$_GET['codassoluto']);
    $queryone->execute();
    //  /*
    // QUESTA PARTE MODIFICA NOMIMISURE PASSANDO PER TIPOMISURA 
    // */
    $quedy=$db -> prepare('DELETE FROM techseum.misure WHERE :codassoluto=codassoluto;');
    $quedy -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quedy->execute();
    for($i=0;$i<count($_GET['valore']);$i++) {
        $queryietta = $db -> prepare('UPDATE techseum.misure SET tipomisura=:tipomisura,valore=:valore  WHERE codassoluto=:codassoluto;');
        $queryietta -> bindValue(':codassoluto', $_GET['codassoluto']);
        $queryietta -> bindValue(':tipomisura', $_GET['tipomisura'][$i]);
        $queryietta -> bindValue(':valore', $_GET['valore'][$i]);
        $queryietta->execute();
    }
    // // /*
    // // QUESTA PARTE MODIFICA IL NOME DEL MATERIALE DA COMPOSTODA
    // // */
    $quedd=$db -> prepare('DELETE FROM techseum.compostoda WHERE :codassoluto=codassoluto;');
    $quedd -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quedd->execute();
    for($i=0;$i<count($_GET['codmateriale']);$i++) {
        $querio=$db -> prepare('INSERT INTO techseum.compostoda(codassoluto,codmateriale) VALUES (:codassoluto,:codmateriale);');
        $querio -> bindValue(':codassoluto', $_GET['codassoluto']);
        $querio -> bindValue(':codmateriale', $_GET['codmateriale'][$i]);
        $querio -> execute();
    }
    // // /*
    // // QUESTA PARTE MODIFICA LA DIDASCALIA PARTENDO DA CODASSOLUTO
    // // */
    $quedt=$db -> prepare('DELETE FROM techseum.didascalie WHERE :codassoluto=codassoluto;');
    $quedt -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quedt->execute();
    for($i=0;$i<count($_GET['lingua']);$i++) {
        $querd = $db -> prepare('UPDATE techseum.didascalie SET didascalia=:didascalia,lingua=:lingua  WHERE codassoluto=:codassoluto;');
        $querd -> bindValue(':codassoluto', $_GET['codassoluto']);
        $querd -> bindValue(':didascalia', $_GET['didascalia'][$i]);
        $querd -> bindValue(':lingua', $_GET['lingua'][$i]); 
        $querd->execute();
    }
    // // /*
    // // QUESTA PARTE MODIFICA ACQUISIZIONI IN PARTICOLARE IL CODICE ACQUISIZIONE PARTENDO DA 
    // // */
    $quera = $db -> prepare('UPDATE techseum.acquisizioni SET tipoacquisizione=:tipoacquisizione, dasoggetto=:dasoggetto, quantita=:quantita,codacquisizione=:codacquisizione  WHERE codassoluto=:codassoluto;');
    $quera -> bindValue(':tipoacquisizione', $_GET['tipoacquisizione']);
    $quera -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quera -> bindValue(':codacquisizione', $_GET['codacquisizione']);
    $quera -> bindValue(':quantita', $_GET['quantita']);
    $quera -> bindValue(':dasoggetto', $_GET['dasoggetto']);
    $quera->execute();
    // // /*
    // // QUESTA PARTE MODIFICA MEDIA IN PARTICOLARE NMEDIA PARTENDO DA CODASSOLUTO
    // // */
    $quedr=$db -> prepare('DELETE FROM techseum.media WHERE :codassoluto=codassoluto;');
    $quedr -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quedr->execute();
    for($i=0;$i<count($_GET['link']);$i++) 
    {
        $quere = $db -> prepare('UPDATE techseum.media SET nmedia=:nmedia, tipo=:tipo, fonte=:fonte, link=:link WHERE codassoluto=:codassoluto;');
        $quere -> bindValue(':nmedia', $_GET['nmedia'][$i]);
        $quere -> bindValue(':codassoluto', $_GET['codassoluto'][$i]);
        $quere -> bindValue(':tipo', $_GET['tipo'][$i]);
        $quere -> bindValue(':link', $_GET['link'][$i]);
        $quere -> bindValue(':fonte', $_GET['fonte'][$i]);
        $quere->execute();
    }
    // /*
    // QUESTA PARTE MODIFICA PARTI IN PARTICOLARE IL NOMEPARTE PARTENDO DA CODASSOLUTO
    // */
    $queri = $db -> prepare('UPDATE techseum.parti SET nomeparte=:nomeparte, nparte=:nparte WHERE codassoluto=:codassoluto;');
    $queri -> bindValue(':nomeparte', $_GET['nomeparte']);
    $queri -> bindValue(':codassoluto', $_GET['codassoluto']);
    $queri -> bindValue(':nparte', $_GET['nparte']);
    $queri->execute();

    // Output dell'API in formato JSON
    echo '{"status":1, "message":"reperto updated"}';
    exit();
} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}