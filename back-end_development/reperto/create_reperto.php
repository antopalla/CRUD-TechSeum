<?php
// API PER L'AGGIUNTA DI UN REPERTO AL DATABASE

require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');

// Per richieste tramite JSON e non tramite FORM utilizzare
//$credenziali = json_decode(file_get_contents('php://input'), true);

// Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
try{
    $query = $db -> prepare('INSERT INTO techseum.repertinuova (datacatalogazione, nome, sezione, codrelativo, definizione, denominazionestorica, descrizione, modouso, annoiniziouso, annofineuso, scopo, stato, osservazioni) VALUES (:datacatalogazione, :nome, :sezione, :codrelativo, :definizione, :denominazionestorica, :descrizione, :modouso, :annoiniziouso, :annofineuso, :scopo, :stato, :osservazioni);'); 
    $query -> bindValue(':datacatalogazione', $_GET['datacatalogazione']); 
    $query -> bindValue(':nome', $_GET['nome']); 
    $query -> bindValue(':sezione', $_GET['sezione']); 
    $query -> bindValue(':codrelativo', $_GET['codrelativo']); 
    $query -> bindValue(':definizione', $_GET['definizione']); 
    $query -> bindValue(':denominazionestorica', $_GET['denominazionestorica']);
    $query -> bindValue(':descrizione', $_GET['descrizione']); 
    $query -> bindValue(':modouso', $_GET['modouso']); 
    $query -> bindValue(':annoiniziouso', $_GET['annoiniziouso']); 
    $query -> bindValue(':annofineuso', $_GET['annofineuso']); 
    $query -> bindValue(':scopo', $_GET['scopo']);
    $query -> bindValue(':stato', $_GET['stato']); 
    $query -> bindValue(':osservazioni', $_GET['osservazioni']);   
    $query -> execute();
    $quert = $db -> prepare('SELECT codassoluto FROM techseum.repertinuova order by codassoluto desc limit 1;'); 
    $quert -> execute();
    $codas= $quert -> fetchAll();
    $codassoluto=$codas[0]['codassoluto'];

    $querion = $db -> prepare('INSERT INTO techseum.hafatto(codassoluto,codautore) VALUES (:codassoluto,:codautore);');
    $querion -> bindValue(':codassoluto', $codassoluto);
    $querion -> bindValue(':codautore', $_GET['codautore']);
    $querion -> execute();

    $querie=$db -> prepare('INSERT INTO techseum.didascalie(codassoluto,lingua,didascalia) VALUES (:codassoluto,:lingua,:didascalia);');
    $querie -> bindValue(':lingua', $_GET['lingua']);
    $querie -> bindValue(':codassoluto', $codassoluto);
    $querie -> bindValue(':didascalia', $_GET['didascalia']);
    $querie -> execute();

    $querio=$db -> prepare('INSERT INTO techseum.compostoda(codassoluto,codmateriale) VALUES (:codassoluto,:codmateriale);');
    $querio -> bindValue(':codmateriale', $_GET['codmateriale']);
    $querio -> bindValue(':codassoluto', $codassoluto);
    $querio -> execute();

    $querim=$db -> prepare('INSERT INTO techseum.misure(codassoluto,tipomisura,valore) VALUES (:codassoluto,:tipomisura,:valore);');
    $querim -> bindValue(':tipomisura', $_GET['tipomisura']);
    $querim -> bindValue(':codassoluto', $codassoluto);
    $querim -> bindValue(':valore', $_GET['valore']);
    $querim -> execute();

    $querip=$db -> prepare('INSERT INTO techseum.parti(codassoluto,nparte,nomeparte) VALUES (:codassoluto,:nparte,:nomeparte);');
    $querip -> bindValue(':nparte', $_GET['nparte']);
    $querip -> bindValue(':codassoluto', $codassoluto);
    $querip -> bindValue(':nomeparte', $_GET['nomeparte']);
    $querip -> execute();

    $querih=$db -> prepare('INSERT INTO techseum.acquisizioni(codassoluto,codacquisizione,tipoacquisizione,dasoggetto,quantita) VALUES (:codassoluto,:codacquisizione,:tipoacquisizione,:dasoggetto,:quantita);');
    $querih -> bindValue(':codacquisizione', $_GET['codacquisizione']);
    $querih -> bindValue(':codassoluto', $codassoluto);
    $querih -> bindValue(':tipoacquisizione', $_GET['tipoacquisizione']);
    $querih -> bindValue(':dasoggetto', $_GET['dasoggetto']);
    $querih -> bindValue(':quantita', $_GET['quantita']);

    $queriem=$db -> prepare('INSERT INTO techseum.media(codassoluto,nmedia,tipo,link,fonte) VALUES (:codassoluto,:nmedia,:tipo,:link,:fonte);');
    $queriem -> bindValue(':nmedia', $_GET['nmedia']);
    $queriem -> bindValue(':codassoluto', $codassoluto);
    $queriem -> bindValue(':tipo', $_GET['tipo']);
    $queriem -> bindValue(':link', $_GET['link']);
    $queriem -> bindValue(':fonte', $_GET['fonte']);
    echo '{"status":1, "message":"reperto created"}';
    exit();

} catch(PDOException $ex) {
    err("Errore nell'esecuzione della query", __LINE__);
}


