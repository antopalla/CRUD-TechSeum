<?php
require_once(__DIR__.'/../protected/headers.php');
require_once(__DIR__.'/../protected/functions.php');
require_once(__DIR__.'/../protected/check_session.php');
require_once(__DIR__.'/../protected/connessioneDB.php');


// Utilizzo del try - catch per eventuali errori nella query
try{
    $query = $db -> prepare('INSERT INTO techseum.repertinuova (datacatalogazione, nome, sezione, codrelativo, definizione, denominazionestorica, descrizione, modouso, annoiniziouso, annofineuso, scopo, stato, osservazioni) VALUES (:datacatalogazione, :nome, :sezione, :codrelativo, :definizione, :denominazionestorica, :descrizione, :modouso, :annoiniziouso, :annofineuso, :scopo, :stato, :osservazioni);'); // PDO
    $query -> bindValue(':datacatalogazione', $_GET['datacatalogazione']); // NO SQL INJECTION
    $query -> bindValue(':nome', $_GET['nome']); // NO SQL INJECTION
    $query -> bindValue(':sezione', $_GET['sezione']); // NO SQL INJECTION
    $query -> bindValue(':codrelativo', $_GET['codrelativo']); // NO SQL INJECTION
    $query -> bindValue(':definizione', $_GET['definizione']); // NO SQL INJECTION
    $query -> bindValue(':denominazionestorica', $_GET['denominazionestorica']); // NO SQL INJECTION
    $query -> bindValue(':descrizione', $_GET['descrizione']); // NO SQL INJECTION
    $query -> bindValue(':modouso', $_GET['modouso']); // NO SQL INJECTION
    $query -> bindValue(':annoiniziouso', $_GET['annoiniziouso']); // NO SQL INJECTION
    $query -> bindValue(':annofineuso', $_GET['annofineuso']); // NO SQL INJECTION
    $query -> bindValue(':scopo', $_GET['scopo']); // NO SQL INJECTION
    $query -> bindValue(':stato', $_GET['stato']); // NO SQL INJECTION
    $query -> bindValue(':osservazioni', $_GET['osservazioni']); // NO SQL INJECTION    
    $query -> execute();
    $quert = $db -> prepare('SELECT codassoluto FROM techseum.repertinuova order by codassoluto desc limit 1;'); // PDO
    $quert -> execute();
    $codas= $quert -> fetchAll();
    $codassoluto=$codas[0]['codassoluto'];

    $querion = $db -> prepare('INSERT INTO techseum.hafatto(codassoluto,codautore) VALUES (:codassoluto,:codautore);');
    $querion -> bindValue(':codassoluto', $codassoluto);
    $querion -> bindValue(':codautore', $_GET['codautore']); // NO SQL INJECTION
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


