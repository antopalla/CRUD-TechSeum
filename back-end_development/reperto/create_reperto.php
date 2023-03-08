<?php
    // API PER L'AGGIUNTA DI UN REPERTO AL DATABASE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/connessioneDB.php');

    // Per richieste tramite JSON e non tramite FORM utilizzare
    $data_da_json = json_decode(file_GET_contents('php://input'), true);

    // Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    try {
        // Query per inserimento dati nella tabella repertinuova
        $query = $db -> prepare('INSERT INTO techseum.repertinuova (datacatalogazione, nome, sezione, codrelativo, definizione, denominazionestorica, descrizione, modouso, annoiniziouso, annofineuso, scopo, stato, osservazioni) VALUES (:datacatalogazione, :nome, :sezione, :codrelativo, :definizione, :denominazionestorica, :descrizione, :modouso, :annoiniziouso, :annofineuso, :scopo, :stato, :osservazioni);'); 
        $query -> bindValue(':datacatalogazione', $data_da_json['datacatalogazione']); 
        $query -> bindValue(':nome', $data_da_json['nome']); 
        $query -> bindValue(':sezione', $data_da_json['sezione']); 
        $query -> bindValue(':codrelativo', $data_da_json['codrelativo']); 
        $query -> bindValue(':definizione', $data_da_json['definizione']); 
        $query -> bindValue(':denominazionestorica', $data_da_json['denominazionestorica']);
        $query -> bindValue(':descrizione', $data_da_json['descrizione']); 
        $query -> bindValue(':modouso', $data_da_json['modouso']); 
        $query -> bindValue(':annoiniziouso', $data_da_json['annoiniziouso']); 
        $query -> bindValue(':annofineuso', $data_da_json['annofineuso']); 
        $query -> bindValue(':scopo', $data_da_json['scopo']);
        $query -> bindValue(':stato', $data_da_json['stato']); 
        $query -> bindValue(':osservazioni', $data_da_json['osservazioni']);   
        $query -> execute();
        $quert = $db -> prepare('SELECT codassoluto FROM techseum.repertinuova ORDER BY codassoluto desc limit 1;'); 
        $quert -> execute();
        $codas= $quert -> fetchAll();
        $codassoluto=$codas[0]['codassoluto'];
        $querion = $db -> prepare('INSERT INTO techseum.hafatto(codassoluto,codautore) VALUES (:codassoluto,:codautore);');
        $querion -> bindValue(':codassoluto', $codassoluto);
        $querion -> bindValue(':codautore', $data_da_json['codautore']);
        $querion -> execute();

        // Query per inserimento dati nella tabella didascalie
        $querie=$db -> prepare('INSERT INTO techseum.didascalie(codassoluto,lingua,didascalia) VALUES (:codassoluto,:lingua,:didascalia);');
        $querie -> bindValue(':lingua', $data_da_json['lingua']);
        $querie -> bindValue(':codassoluto', $codassoluto);
        $querie -> bindValue(':didascalia', $data_da_json['didascalia']);
        $querie -> execute();
        
        // Query per inserimento dati nella tabella compostoda
        for($i=0;$i<count($data_da_json['codmateriale']);$i++) {
            $querio=$db -> prepare('INSERT INTO techseum.compostoda(codassoluto,codmateriale) VALUES (:codassoluto,:codmateriale);');
            $querio -> bindValue(':codmateriale', $data_da_json['codmateriale'][$i]);
            $querio -> bindValue(':codassoluto', $codassoluto);
            $querio -> execute();
        }

        // Query per inserimento dati nella tabella misure
        for($i=0;$i<count($data_da_json['tipomisura']);$i++) {
            $querim=$db -> prepare('INSERT INTO techseum.misure(codassoluto,tipomisura,valore) VALUES (:codassoluto,:tipomisura,:valore);');
            $querim -> bindValue(':tipomisura', $data_da_json['tipomisura'][$i]);
            $querim -> bindValue(':codassoluto', $codassoluto);
            $querim -> bindValue(':valore', $data_da_json['valore'][$i]);
            $querim -> execute();
        }

        // Query per inserimento dati nella tabella parti
        for($i=0;$i<count($data_da_json['nomeparte']);$i++) {
            $querip=$db -> prepare('INSERT INTO techseum.parti(codassoluto,nparte,nomeparte) VALUES (:codassoluto,:nparte,:nomeparte);');
            $querip -> bindValue(':nparte', $data_da_json['nparte'][$i]);
            $querip -> bindValue(':codassoluto', $codassoluto);
            $querip -> bindValue(':nomeparte', $data_da_json['nomeparte'][$i]);
            $querip -> execute();
        }
        
        // Query per inserimento dati nella tabella acquisizioni
        $querih=$db -> prepare('INSERT INTO techseum.acquisizioni(codassoluto,codacquisizione,tipoacquisizione,dasoggetto,quantita) VALUES (:codassoluto,:codacquisizione,:tipoacquisizione,:dasoggetto,:quantita);');
        $querih -> bindValue(':codassoluto', $codassoluto);
        $querih -> bindValue(':codacquisizione', $data_da_json['codacquisizione']);
        $querih -> bindValue(':tipoacquisizione', $data_da_json['tipoacquisizione']);
        $querih -> bindValue(':dasoggetto', $data_da_json['dasoggetto']);
        $querih -> bindValue(':quantita', $data_da_json['quantita']);
        $querih -> execute();
        
        // Query per inserimento dati nella tabella media
        for($i=0;$i<count($data_da_json['link']);$i++) {
            $queriem=$db -> prepare('INSERT INTO techseum.media(codassoluto,nmedia,tipo,link,fonte) VALUES (:codassoluto,:nmedia,:tipo,:link,:fonte);');
            $queriem -> bindValue(':codassoluto', $codassoluto);
            $queriem -> bindValue(':nmedia', $data_da_json['nmedia'][$i]);
            $queriem -> bindValue(':tipo', $data_da_json['tipo'][$i]);
            $queriem -> bindValue(':link', $data_da_json['link'][$i]);
            $queriem -> bindValue(':fonte', $data_da_json['fonte'][$i]);
            $queriem -> execute();
        }

        // Output dell'API in formato JSON    
        echo '{"status":1, "message":"Reperto aggiunto al database"}';
        exit();

    } catch(PDOException $ex) {
        err("Errore nell'esecuzione della query", __LINE__);
    }


