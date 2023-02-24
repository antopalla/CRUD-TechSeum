<?php
    // API PER L'AGGIUNTA DI UN REPERTO AL DATABASE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/connessioneDB.php');

    // Per richieste tramite JSON e non tramite FORM utilizzare
    //$credenziali = json_decode(file_GET_contents('php://input'), true);

    $datas = json_decode(file_GET_contents('php://input'), true);

    // Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    try{
        $query = $db -> prepare('INSERT INTO techseum.repertinuova (datacatalogazione, nome, sezione, codrelativo, definizione, denominazionestorica, descrizione, modouso, annoiniziouso, annofineuso, scopo, stato, osservazioni) VALUES (:datacatalogazione, :nome, :sezione, :codrelativo, :definizione, :denominazionestorica, :descrizione, :modouso, :annoiniziouso, :annofineuso, :scopo, :stato, :osservazioni);'); 
        $query -> bindValue(':datacatalogazione', $datas['datacatalogazione']); 
        $query -> bindValue(':nome', $datas['nome']); 
        $query -> bindValue(':sezione', $datas['sezione']); 
        $query -> bindValue(':codrelativo', $datas['codrelativo']); 
        $query -> bindValue(':definizione', $datas['definizione']); 
        $query -> bindValue(':denominazionestorica', $datas['denominazionestorica']);
        $query -> bindValue(':descrizione', $datas['descrizione']); 
        $query -> bindValue(':modouso', $datas['modouso']); 
        $query -> bindValue(':annoiniziouso', $datas['annoiniziouso']); 
        $query -> bindValue(':annofineuso', $datas['annofineuso']); 
        $query -> bindValue(':scopo', $datas['scopo']);
        $query -> bindValue(':stato', $datas['stato']); 
        $query -> bindValue(':osservazioni', $datas['osservazioni']);   
        $query -> execute();
        $quert = $db -> prepare('SELECT codassoluto FROM techseum.repertinuova ORDER BY codassoluto desc limit 1;'); 
        $quert -> execute();
        $codas= $quert -> fetchAll();
        $codassoluto=$codas[0]['codassoluto'];
        $querion = $db -> prepare('INSERT INTO techseum.hafatto(codassoluto,codautore) VALUES (:codassoluto,:codautore);');
        $querion -> bindValue(':codassoluto', $codassoluto);
        $querion -> bindValue(':codautore', $datas['codautore']);
        $querion -> execute();

        $querie=$db -> prepare('INSERT INTO techseum.didascalie(codassoluto,lingua,didascalia) VALUES (:codassoluto,:lingua,:didascalia);');
        $querie -> bindValue(':lingua', $datas['lingua']);
        $querie -> bindValue(':codassoluto', $codassoluto);
        $querie -> bindValue(':didascalia', $datas['didascalia']);
        $querie -> execute();
        
        for($i=0;$i<count($datas['codmateriale']);$i++)
        {
            $querio=$db -> prepare('INSERT INTO techseum.compostoda(codassoluto,codmateriale) VALUES (:codassoluto,:codmateriale);');
            $querio -> bindValue(':codmateriale', $datas['codmateriale'][$i]);
            $querio -> bindValue(':codassoluto', $codassoluto);
            $querio -> execute();
        }

        for($i=0;$i<count($datas['tipomisura']);$i++)
        {
            $querim=$db -> prepare('INSERT INTO techseum.misure(codassoluto,tipomisura,valore) VALUES (:codassoluto,:tipomisura,:valore);');
            $querim -> bindValue(':tipomisura', $datas['tipomisura'][$i]);
            $querim -> bindValue(':codassoluto', $codassoluto);
            $querim -> bindValue(':valore', $datas['valore'][$i]);
            $querim -> execute();
        }
        for($i=0;$i<count($datas['nomeparte']);$i++)
        {
            $querip=$db -> prepare('INSERT INTO techseum.parti(codassoluto,nparte,nomeparte) VALUES (:codassoluto,:nparte,:nomeparte);');
            $querip -> bindValue(':nparte', $datas['nparte'][$i]);
            $querip -> bindValue(':codassoluto', $codassoluto);
            $querip -> bindValue(':nomeparte', $datas['nomeparte'][$i]);
            $querip -> execute();
        }
        
        $querih=$db -> prepare('INSERT INTO techseum.acquisizioni(codassoluto,tipoacquisizione,dasoggetto,quantita) VALUES (:codassoluto,:tipoacquisizione,:dasoggetto,:quantita);');
        $querih -> bindValue(':codassoluto', $codassoluto);
        $querih -> bindValue(':tipoacquisizione', $datas['tipoacquisizione']);
        $querih -> bindValue(':dasoggetto', $datas['dasoggetto']);
        $querih -> bindValue(':quantita', $datas['quantita']);
        
        for($i=0;$i<count($datas['tipo']);$i++)
        {
            $queriem=$db -> prepare('INSERT INTO techseum.media(codassoluto,nmedia,tipo,link,fonte) VALUES (:codassoluto,:nmedia,:tipo,:link,:fonte);');
            $queriem -> bindValue(':nmedia', $datas['nmedia'][$i]);
            $queriem -> bindValue(':codassoluto', $codassoluto);
            $queriem -> bindValue(':tipo', $datas['tipo'][$i]);
            $queriem -> bindValue(':link', $datas['link'][$i]);
            $queriem -> bindValue(':fonte', $datas['fonte'][$i]);
        }

        // Output dell'API in formato JSON    
        echo '{"status":1, "message":"Reperto aggiunto al database"}';
        exit();

    } catch(PDOException $ex) {
        err("Errore nell'esecuzione della query", __LINE__);
    }


