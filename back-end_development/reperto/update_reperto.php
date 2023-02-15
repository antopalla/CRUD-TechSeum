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
    ATTRIBUTI MODIFICABILI IN REPERTINUOVA:
    nome=:nome,sezione=:sezione, 
    codrelativo=:codrelativo, 
    definizione=:definizione,
    denominazionestorica=:denominazionestorica, 
    descrizione=:descrizione, 
    modouso=:modouso, annoiniziouso=:annoiniziouso, 
    annofineuso=:annofineuso, 
    scopo=:scopo, 
    stato=:stato,
    osservazioni=:osservazioni
    */
    $query = $db -> prepare('UPDATE techseum.repertinuova SET nome=:nome WHERE codassoluto=:codassoluto;');
    $query -> bindValue(':codassoluto', $_GET['codassoluto']); 
    $query -> bindValue(':nome', $_GET['nome']); 
    /*
    QUESTA PARTE MODIFICA IL NOME DELL'AUTORE PARTENDO DAL CODICEASSOLUTO 
    ATTRIBUTI MODIFICABILI NELLA TABELLA AUTORE:
    annonascita=:annonascita,annofine=:annofine
    */
    $quert = $db -> prepare('SELECT codautore FROM techseum.hafatto  WHERE codassoluto=:codassoluto;'); // PDO
    $quert -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quert -> execute();
    $result = $quert -> fetchAll();
    $queryone = $db -> prepare('UPDATE techseum.autore SET nomeautore=:nomeautore WHERE codautore=:codautore;');
    $queryone -> bindValue(':codautore',$result[0]['codautore']);
    $queryone -> bindValue(':nomeautore', $_GET['nomeautore']);
    $queryone->execute();
     /*
    QUESTA PARTE MODIFICA NOMIMISURE PASSANDO PER TIPOMISURA 
    ATTRIBUTI MODIFICABILI IN NOMIMISURE:
    unitadimisura=:unitadimisura
    misure_tipomisura=:misure_tipomisura
    annofine=:annofine
    */
    $quertit= $db -> prepare('SELECT tipomisura FROM techseum.misure  WHERE codassoluto=:codassoluto;');
    $quertit -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quertit -> execute();
    $resulto = $quertit -> fetchAll();
    $queryietta = $db -> prepare('UPDATE techseum.nomimisure SET nomemisura=:nomemisura WHERE tipomisura=:tipomisura;');
    $queryietta -> bindValue(':tipomisura',$resulto[0]['tipomisura']);
    $queryietta -> bindValue(':nomemisura', $_GET['nomemisura']);
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
    $querd = $db -> prepare('UPDATE techseum.didascalie SET didascalia=:didascalia WHERE codassoluto=:codassoluto;');
    $querd -> bindValue(':codassoluto', $_GET['codassoluto']);
    $querd -> bindValue(':didascalia', $_GET['didascalia']);
    $querd->execute();
    /*
    QUESTA PARTE MODIFICA ACQUISIZIONI IN PARTICOLARE IL CODICE ACQUISIZIONE PARTENDO DA 
    */
    $quera = $db -> prepare('UPDATE techseum.acquisizioni SET tipoacquisizione=:tipoacquisizione WHERE codassoluto=:codassoluto;');
    $quera -> bindValue(':tipoacquisizione', $_GET['tipoacquisizione']);
    $quera -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quera->execute();
    /*
    QUESTA PARTE MODIFICA MEDIA IN PARTICOLARE NMEDIA PARTENDO DA CODASSOLUTO
    */
    $quere = $db -> prepare('UPDATE techseum.media SET nmedia=:nmedia WHERE codassoluto=:codassoluto;');
    $quere -> bindValue(':nmedia', $_GET['nmedia']);
    $quere -> bindValue(':codassoluto', $_GET['codassoluto']);
    $quere->execute();
    /*
    QUESTA PARTE MODIFICA PARTI IN PARTICOLARE IL NOMEPARTE PARTENDO DA CODASSOLUTO
    */
    $queri = $db -> prepare('UPDATE techseum.parti SET nomeparte=:nomeparte WHERE codassoluto=:codassoluto;');
    $queri -> bindValue(':nomeparte', $_GET['nomeparte']);
    $queri -> bindValue(':codassoluto', $_GET['codassoluto']);
    $queri->execute();
    echo '{"status":1, "message":"reperto updated"}';
    exit();
}
catch(PDOException $ex)
{
    err("Errore nell'esecuzione della query", __LINE__);
}


echo '{"status":1, "message":"reperto updated"}';