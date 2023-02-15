<?php
require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');
// Header per indicare che le richieste HTTP sono in formato JSON
header('Content-Type: application/json');

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
    $quert = $db -> prepare('SELECT codautore FROM techseum.hafatto  WHERE codassoluto=:codassoluto;'); // PDO
    $quert -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quert -> execute();
    $result = $quert -> fetchAll();
    $queryone = $db -> prepare('UPDATE techseum.autore SET nomeautore=:nomeautore, annonascita=:annonascita, annofine=:annofine WHERE codautore=:codautore;');
    $queryone -> bindValue(':codautore',$result[0]['codautore']);
    $queryone -> bindValue(':nomeautore', $_GET['nomeautore']);
    $queryone -> bindValue(':annonascita', $_GET['annonascita']);
    $queryone -> bindValue(':annofine', $_GET['annofine']);
    $queryone->execute();
     /*
    QUESTA PARTE MODIFICA NOMIMISURE PASSANDO PER TIPOMISURA 
    */
    $quertit= $db -> prepare('SELECT tipomisura FROM techseum.misure  WHERE codassoluto=:codassoluto;');
    $quertit -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quertit -> execute();
    $resulto = $quertit -> fetchAll();
    $queryietta = $db -> prepare('UPDATE techseum.nomimisure SET nomemisura=:nomemisura, unitadimisura=:unitadimisura,misure_tipomisura=:misure_tipomisura,annofine=:annofine WHERE tipomisura=:tipomisura;');
    $queryietta -> bindValue(':tipomisura',$resulto[0]['tipomisura']);
    $queryietta -> bindValue(':nomemisura', $_GET['nomemisura']);
    $queryietta -> bindValue(':unitadimisura', $_GET['unitadimisura']);
    $queryietta -> bindValue(':misure_tipomisura', $_GET['misure_tipomisura']);
    $queryietta -> bindValue(':annofine', $_GET['annofine']);
    $queryietta->execute();
    /*
    QUESTA PARTE MODIFICA IL NOME DEL MATERIALE DA COMPOSTODA
    */
    $querr = $db -> prepare('SELECT codmateriale from techseum.compostoda WHERE codassoluto=:codassoluto;');
    $querr -> bindValue(':codassoluto', $_GET['codassoluto']);
    $querr->execute();
    $resu = $querr -> fetchAll();
    $quer= $db -> prepare('UPDATE techseum.materiali SET nomemateriale=:nomemateriale WHERE codmateriale=:codmateriale;');
    $quer -> bindValue(':codmateriale', $resu[0]['codmateriale']);
    $quer -> bindValue(':nomemateriale', $_GET['nomemateriale']);
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