<?php

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');


try{
    /*
    QUESTA PARTE MODIFICA LA TABELLA REPERTINUOVA INSERENDO SOLO UN NUOVO NOME AL REPERTO.
    */
    $query = $db -> prepare('UPDATE techseum.repertinuova SET nome=:nome, datacatalogazione=:datacatalogazione, sezione=:sezione, codrelativo=:codrelativo, definizione=:definizione, denominazionestorica=:denominazionestorica, descrizione=:descrizione, modouso=:modouso, annoiniziouso=:annoiniziouso, annofineuso=:annofineuso, scopo=:scopo, stato=:stato, osservazioni=:osservazioni WHERE codassoluto=:codassoluto;');
    $query -> bindValue(':codassoluto', $_GET['codassoluto']); 
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
    
    $queryone = $db -> prepare('UPDATE techseum.hafatto SET codautore=:codautore,  WHERE codassoluto=:codassoluto;');
    $queryone -> bindValue(':codautore',$_GET['codautore']);
    $queryone -> bindValue(':codassoluto',$_GET['codassoluto']);
    $queryone->execute();
     /*
    QUESTA PARTE MODIFICA NOMIMISURE PASSANDO PER TIPOMISURA 
    */
    $queryietta = $db -> prepare('UPDATE techseum.misure SET tipomisura=:tipomisura,valore=:valore  WHERE codassoluto=:codassoluto;');
    $queryietta -> bindValue(':codassoluto', $_GET['codassoluto']);
    $queryietta -> bindValue(':tipomisura', $_GET['tipomisura']);
    $queryietta -> bindValue(':valore', $_GET['valore']);
    $queryietta->execute();
    /*
    QUESTA PARTE MODIFICA IL NOME DEL MATERIALE DA COMPOSTODA
    */
    $quer= $db -> prepare('UPDATE techseum.compostoda SET codmateriale=:codmateriale WHERE codassoluto=:codassoluto;');
    $quer -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quer -> bindValue(':codmateriale', $_GET['codmateriale']);
    $quer->execute();
    /*
    QUESTA PARTE MODIFICA LA DIDASCALIA PARTENDO DA CODASSOLUTO
    */
    $querd = $db -> prepare('UPDATE techseum.didascalie SET didascalia=:didascalia,lingua=:lingua  WHERE codassoluto=:codassoluto;');
    $querd -> bindValue(':codassoluto', $_GET['codassoluto']);
    $querd -> bindValue(':didascalia', $_GET['didascalia']);
    $querd -> bindValue(':lingua', $_GET['lingua']); 
    $querd->execute();
    /*
    QUESTA PARTE MODIFICA ACQUISIZIONI IN PARTICOLARE IL CODICE ACQUISIZIONE PARTENDO DA 
    */
    $quera = $db -> prepare('UPDATE techseum.acquisizioni SET tipoacquisizione=:tipoacquisizione, dasoggetto=:dasoggetto, quantita=:quantita WHERE codassoluto=:codassoluto;');
    $quera -> bindValue(':tipoacquisizione', $_GET['tipoacquisizione']);
    $quera -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quera -> bindValue(':quantita', $_GET['quantita']);
    $quera -> bindValue(':dasoggetto', $_GET['dasoggetto']);
    $quera->execute();
    /*
    QUESTA PARTE MODIFICA MEDIA IN PARTICOLARE NMEDIA PARTENDO DA CODASSOLUTO
    */
    $quere = $db -> prepare('UPDATE techseum.media SET nmedia=:nmedia, tipo=:tipo, fonte=:fonte, link=:link WHERE codassoluto=:codassoluto;');
    $quere -> bindValue(':nmedia', $_GET['nmedia']);
    $quere -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quere -> bindValue(':tipo', $_GET['tipo']);
    $quere -> bindValue(':link', $_GET['link']);
    $quere -> bindValue(':fonte', $_GET['fonte']);
    $quere->execute();
    /*
    QUESTA PARTE MODIFICA PARTI IN PARTICOLARE IL NOMEPARTE PARTENDO DA CODASSOLUTO
    */
    $queri = $db -> prepare('UPDATE techseum.parti SET nomeparte=:nomeparte, nparte=:nparte WHERE codassoluto=:codassoluto;');
    $queri -> bindValue(':nomeparte', $_GET['nomeparte']);
    $queri -> bindValue(':codassoluto', $_GET['codassoluto']);
    $queri -> bindValue(':nparte', $_GET['nparte']);
    $queri->execute();
    echo '{"status":1, "message":"reperto updated"}';
    exit();
}
catch(PDOException $ex)
{
    err("Errore nell'esecuzione della query", __LINE__);
}


echo '{"status":1, "message":"reperto updated"}';