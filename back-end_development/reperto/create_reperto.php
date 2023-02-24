<?php
// API PER L'AGGIUNTA DI UN REPERTO AL DATABASE

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Per richieste tramite JSON e non tramite FORM utilizzare
//$credenziali = json_decode(file_GET_contents('php://input'), true);

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try{
    $query = $db -> prepare('INSERT INTO techseum.repertinuova (datacatalogazione, nome, sezione, codrelativo, definizione, denominazionestorica, descrizione, modouso, annoiniziouso, annofineuso, scopo, stato, osservazioni) VALUES (:datacatalogazione, :nome, :sezione, :codrelativo, :definizione, :denominazionestorica, :descrizione, :modouso, :annoiniziouso, :annofineuso, :scopo, :stato, :osservazioni);'); 
    $query -> bindValue(':datacatalogazione', $_POST['datacatalogazione']); 
    $query -> bindValue(':nome', $_POST['nome']); 
    $query -> bindValue(':sezione', $_POST['sezione']); 
    $query -> bindValue(':codrelativo', $_POST['codrelativo']); 
    $query -> bindValue(':definizione', $_POST['definizione']); 
    $query -> bindValue(':denominazionestorica', $_POST['denominazionestorica']);
    $query -> bindValue(':descrizione', $_POST['descrizione']); 
    $query -> bindValue(':modouso', $_POST['modouso']); 
    $query -> bindValue(':annoiniziouso', $_POST['annoiniziouso']); 
    $query -> bindValue(':annofineuso', $_POST['annofineuso']); 
    $query -> bindValue(':scopo', $_POST['scopo']);
    $query -> bindValue(':stato', $_POST['stato']); 
    $query -> bindValue(':osservazioni', $_POST['osservazioni']);   
    $query -> execute();
    $quert = $db -> prepare('SELECT codassoluto FROM techseum.repertinuova ORDER BY codassoluto desc limit 1;'); 
    $quert -> execute();
    $codas= $quert -> fetchAll();
    $codassoluto=$codas[0]['codassoluto'];
    $querion = $db -> prepare('INSERT INTO techseum.hafatto(codassoluto,codautore) VALUES (:codassoluto,:codautore);');
    $querion -> bindValue(':codassoluto', $codassoluto);
    $querion -> bindValue(':codautore', $_POST['codautore']);
    $querion -> execute();

    $querie=$db -> prepare('INSERT INTO techseum.didascalie(codassoluto,lingua,didascalia) VALUES (:codassoluto,:lingua,:didascalia);');
    $querie -> bindValue(':lingua', $_POST['lingua']);
    $querie -> bindValue(':codassoluto', $codassoluto);
    $querie -> bindValue(':didascalia', $_POST['didascalia']);
    $querie -> execute();
    
    for($i=0;$i<count($_POST['codmateriale']);$i++)
    {
        $querio=$db -> prepare('INSERT INTO techseum.compostoda(codassoluto,codmateriale) VALUES (:codassoluto,:codmateriale);');
        $querio -> bindValue(':codmateriale', $_POST['codmateriale'][$i]);
        $querio -> bindValue(':codassoluto', $codassoluto);
        $querio -> execute();
    }

    for($i=0;$i<count($_POST['tipomisura']);$i++)
    {
        $querim=$db -> prepare('INSERT INTO techseum.misure(codassoluto,tipomisura,valore) VALUES (:codassoluto,:tipomisura,:valore);');
        $querim -> bindValue(':tipomisura', $_POST['tipomisura'][$i]);
        $querim -> bindValue(':codassoluto', $codassoluto);
        $querim -> bindValue(':valore', $_POST['valore'][$i]);
        $querim -> execute();
    }
    for($i=0;$i<count($_POST['nomeparte']);$i++)
    {
        $querip=$db -> prepare('INSERT INTO techseum.parti(codassoluto,nparte,nomeparte) VALUES (:codassoluto,:nparte,:nomeparte);');
        $querip -> bindValue(':nparte', $_POST['nparte']);
        $querip -> bindValue(':codassoluto', $codassoluto);
        $querip -> bindValue(':nomeparte', $_POST['nomeparte'][$i]);
        $querip -> execute();
    }
    
    $querih=$db -> prepare('INSERT INTO techseum.acquisizioni(codassoluto,tipoacquisizione,dasoggetto,quantita) VALUES (:codassoluto,:tipoacquisizione,:dasoggetto,:quantita);');
    $querih -> bindValue(':codassoluto', $codassoluto);
    $querih -> bindValue(':tipoacquisizione', $_POST['tipoacquisizione']);
    $querih -> bindValue(':dasoggetto', $_POST['dasoggetto']);
    $querih -> bindValue(':quantita', $_POST['quantita']);
    for($i=0;$i<count($_POST['tipo']);$i++)
    {
        $queriem=$db -> prepare('INSERT INTO techseum.media(codassoluto,nmedia,tipo,link,fonte) VALUES (:codassoluto,:nmedia,:tipo,:link,:fonte);');
        $queriem -> bindValue(':nmedia', $_POST['nmedia'][$i]);
        $queriem -> bindValue(':codassoluto', $codassoluto);
        $queriem -> bindValue(':tipo', $_POST['tipo'][$i]);
        $queriem -> bindValue(':link', $_POST['link'][$i]);
        $queriem -> bindValue(':fonte', $_POST['fonte'][$i]);
    }

    // Output dell'API in formato JSON    
    echo '{"status":1, "message":"reperto created"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}


