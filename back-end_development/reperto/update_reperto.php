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
    $query = $db -> prepare('UPDATE techseum.repertinuova SET nome=:nome, datacatalogazione=:datacatalogazione, sezione=:sezione, codrelativo=:codrelativo, definizione=:definizione, denominazionestorica=:denominazionestorica, descrizione=:descrizione, modouso=:modouso, annoiniziouso=:annoiniziouso, annofineuso=:annofineuso, scopo=:scopo, stato=:stato, osservazioni=:osservazioni WHERE codassoluto=:codassoluto;');
    $query -> bindValue(':codassoluto', $_POST['codassoluto']); 
    $query -> bindValue(':datacatalogazione', $_POST['datacatalogazione']); 
    $query -> bindValue(':sezione', $_POST['sezione']); 
    $query -> bindValue(':codrelativo', $_POST['codrelativo']); 
    $query -> bindValue(':definizione', $_POST['definizione']); 
    $query -> bindValue(':denominazionestorica', $_POST['denominazionestorica']); 
    $query -> bindValue(':modouso', $_POST['modouso']); 
    $query -> bindValue(':annoiniziouso', $_POST['annoiniziouso']); 
    $query -> bindValue(':annofineuso', $_POST['annofineuso']); 
    $query -> bindValue(':scopo', $_POST['scopo']); 
    $query -> bindValue(':osservazioni', $_POST['osservazioni']); 
    $query -> bindValue(':stato', $_POST['stato']); 
    $query -> bindValue(':definizione', $_POST['definizione']); 
    $query -> bindValue(':descrizione', $_POST['descrizione']); 
    $query -> execute();
    /*
    QUESTA PARTE MODIFICA IL NOME DELL'AUTORE PARTENDO DAL CODICEASSOLUTO 
    */
    
    $queryone = $db -> prepare('UPDATE techseum.hafatto SET codautore=:codautore,  WHERE codassoluto=:codassoluto;');
    $queryone -> bindValue(':codautore',$_POST['codautore']);
    $queryone -> bindValue(':codassoluto',$_POST['codassoluto']);
    $queryone->execute();
     /*
    QUESTA PARTE MODIFICA NOMIMISURE PASSANDO PER TIPOMISURA 
    */
    $queryietta = $db -> prepare('UPDATE techseum.misure SET tipomisura=:tipomisura,valore=:valore  WHERE codassoluto=:codassoluto;');
    $queryietta -> bindValue(':codassoluto', $_POST['codassoluto']);
    $queryietta -> bindValue(':tipomisura', $_POST['tipomisura']);
    $queryietta -> bindValue(':valore', $_POST['valore']);
    $queryietta->execute();
    /*
    QUESTA PARTE MODIFICA IL NOME DEL MATERIALE DA COMPOSTODA
    */
    $quer= $db -> prepare('UPDATE techseum.compostoda SET codmateriale=:codmateriale WHERE codassoluto=:codassoluto;');
    $quer -> bindValue(':codassoluto', $_POST['codassoluto']);
    $quer -> bindValue(':codmateriale', $_POST['codmateriale']);
    $quer->execute();
    /*
    QUESTA PARTE MODIFICA LA DIDASCALIA PARTENDO DA CODASSOLUTO
    */
    $querd = $db -> prepare('UPDATE techseum.didascalie SET didascalia=:didascalia,lingua=:lingua  WHERE codassoluto=:codassoluto;');
    $querd -> bindValue(':codassoluto', $_POST['codassoluto']);
    $querd -> bindValue(':didascalia', $_POST['didascalia']);
    $querd -> bindValue(':lingua', $_POST['lingua']); 
    $querd->execute();
    /*
    QUESTA PARTE MODIFICA ACQUISIZIONI IN PARTICOLARE IL CODICE ACQUISIZIONE PARTENDO DA 
    */
    $quera = $db -> prepare('UPDATE techseum.acquisizioni SET tipoacquisizione=:tipoacquisizione, dasoggetto=:dasoggetto, quantita=:quantita WHERE codassoluto=:codassoluto;');
    $quera -> bindValue(':tipoacquisizione', $_POST['tipoacquisizione']);
    $quera -> bindValue(':codassoluto', $_POST['codassoluto']);
    $quera -> bindValue(':quantita', $_POST['quantita']);
    $quera -> bindValue(':dasoggetto', $_POST['dasoggetto']);
    $quera->execute();
    /*
    QUESTA PARTE MODIFICA MEDIA IN PARTICOLARE NMEDIA PARTENDO DA CODASSOLUTO
    */
    $quere = $db -> prepare('UPDATE techseum.media SET nmedia=:nmedia, tipo=:tipo, fonte=:fonte, link=:link WHERE codassoluto=:codassoluto;');
    $quere -> bindValue(':nmedia', $_POST['nmedia']);
    $quere -> bindValue(':codassoluto', $_POST['codassoluto']);
    $quere -> bindValue(':tipo', $_POST['tipo']);
    $quere -> bindValue(':link', $_POST['link']);
    $quere -> bindValue(':fonte', $_POST['fonte']);
    $quere->execute();
    /*
    QUESTA PARTE MODIFICA PARTI IN PARTICOLARE IL NOMEPARTE PARTENDO DA CODASSOLUTO
    */
    $queri = $db -> prepare('UPDATE techseum.parti SET nomeparte=:nomeparte, nparte=:nparte WHERE codassoluto=:codassoluto;');
    $queri -> bindValue(':nomeparte', $_POST['nomeparte']);
    $queri -> bindValue(':codassoluto', $_POST['codassoluto']);
    $queri -> bindValue(':nparte', $_POST['nparte']);
    $queri->execute();

    // Output dell'API in formato JSON
    echo '{"status":1, "message":"reperto updated"}';
    exit();



echo '{"status":1, "message":"reperto updated"}';