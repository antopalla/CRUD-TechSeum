<?php
    // API PER L'AGGIORNAMENTO DI UN REPERTO SUL DATABASE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/connessioneDB.php');
    
    // Per richieste tramite JSON e non tramite FORM utilizzare
    $data_da_json = json_decode(file_GET_contents('php://input'), true);

    // Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    try {
        // QUESTA PARTE MODIFICA LA TABELLA REPERTINUOVA INSERENDO SOLO UN NUOVO NOME AL REPERTO.
        $query = $db -> prepare('UPDATE techseum.repertinuova SET nome=:nome, datacatalogazione=:datacatalogazione, sezione=:sezione, codrelativo=:codrelativo, definizione=:definizione, denominazionestorica=:denominazionestorica, descrizione=:descrizione, modouso=:modouso, annoiniziouso=:annoiniziouso, annofineuso=:annofineuso, scopo=:scopo, stato=:stato, osservazioni=:osservazioni WHERE codassoluto=:codassoluto;');
        $query -> bindValue(':codassoluto', $data_da_json['codassoluto']); 
        $query -> bindValue(':nome', $data_da_json['nome']);
        $query -> bindValue(':datacatalogazione', $data_da_json['datacatalogazione']); 
        $query -> bindValue(':sezione', $data_da_json['sezione']); 
        $query -> bindValue(':codrelativo', $data_da_json['codrelativo']); 
        $query -> bindValue(':definizione', $data_da_json['definizione']); 
        $query -> bindValue(':denominazionestorica', $data_da_json['denominazionestorica']); 
        $query -> bindValue(':modouso', $data_da_json['modouso']); 
        $query -> bindValue(':annoiniziouso', $data_da_json['annoiniziouso']); 
        $query -> bindValue(':annofineuso', $data_da_json['annofineuso']); 
        $query -> bindValue(':scopo', $data_da_json['scopo']); 
        $query -> bindValue(':osservazioni', $data_da_json['osservazioni']); 
        $query -> bindValue(':stato', $data_da_json['stato']); 
        $query -> bindValue(':definizione', $data_da_json['definizione']); 
        $query -> bindValue(':descrizione', $data_da_json['descrizione']); 
        $query -> execute();

        //QUESTA PARTE MODIFICA IL NOME DELL'AUTORE PARTENDO DAL CODICEASSOLUTO
        $query_autore = $db -> prepare('SELECT codautore FROM techseum.hafatto WHERE codassoluto=:codassoluto'); 
        $query_autore -> bindValue(':codassoluto', $data_da_json['codassoluto']);
        $query_autore -> execute();
        $righe_tabella_autore = $query_autore -> fetchAll();

        if (count($righe_tabella_autore)==0) {
            $querion = $db -> prepare('INSERT INTO techseum.hafatto(codassoluto,codautore) VALUES (:codassoluto,:codautore);');
            $querion -> bindValue(':codassoluto', $data_da_json['codassoluto']);
            $querion -> bindValue(':codautore', $data_da_json['codautore']);
            $querion -> execute();
        }
        else {
            $queryone = $db -> prepare('UPDATE techseum.hafatto SET codautore=:codautore  WHERE codassoluto=:codassoluto;');
            $queryone -> bindValue(':codautore',$data_da_json['codautore']);
            $queryone -> bindValue(':codassoluto',$data_da_json['codassoluto']);
            $queryone->execute();
        }

        // QUESTA PARTE MODIFICA MATERIALI 
        $quedc=$db -> prepare('DELETE FROM techseum.compostoda WHERE codassoluto=:codassoluto;');
        $quedc -> bindValue(':codassoluto', $data_da_json['codassoluto']);
        $quedc->execute();

        for($i=0;$i<count($data_da_json['codmateriale']);$i++) {
            $queryane = $db -> prepare('INSERT INTO techseum.compostoda(codassoluto, codmateriale) VALUES (:codassoluto, :codmateriale)');
            $queryane -> bindValue(':codmateriale',$data_da_json['codmateriale'][$i]);
            $queryane -> bindValue(':codassoluto',$data_da_json['codassoluto']);
            $queryane->execute();
        }

        // QUESTA PARTE MODIFICA NOMIMISURE PASSANDO PER TIPOMISURA 
        $quedy=$db -> prepare('DELETE FROM techseum.misure WHERE codassoluto=:codassoluto;');
        $quedy -> bindValue(':codassoluto', $data_da_json['codassoluto']);
        $quedy->execute();
        
        for($i=0;$i<count($data_da_json['valore']);$i++) {
            $queryietta = $db -> prepare('INSERT INTO techseum.misure (codassoluto,tipomisura,valore)  VALUES (:codassoluto,:tipomisura,:valore);');
            $queryietta -> bindValue(':codassoluto', $data_da_json['codassoluto']);
            $queryietta -> bindValue(':tipomisura', $data_da_json['tipomisura'][$i]);
            $queryietta -> bindValue(':valore', $data_da_json['valore'][$i]);
            $queryietta->execute();
        }
        
       
        // QUESTA PARTE MODIFICA LA DIDASCALIA PARTENDO DA CODASSOLUTO
        $quedt=$db -> prepare('DELETE FROM techseum.didascalie WHERE :codassoluto=codassoluto;');
        $quedt -> bindValue(':codassoluto', $data_da_json['codassoluto']);
        $quedt->execute();

        $querd = $db -> prepare('INSERT INTO techseum.didascalie(codassoluto,didascalia,lingua) VALUES (:codassoluto,:didascalia,:lingua);');
        $querd -> bindValue(':codassoluto', $data_da_json['codassoluto']);
        $querd -> bindValue(':didascalia', $data_da_json['didascalia']);
        $querd -> bindValue(':lingua', $data_da_json['lingua']); 
        $querd->execute();
        

        // QUESTA PARTE MODIFICA ACQUISIZIONI IN PARTICOLARE IL CODICE ACQUISIZIONE PARTENDO DA 
        $query_acqui = $db -> prepare('SELECT codacquisizione FROM techseum.acquisizioni WHERE codassoluto=:codassoluto'); 
        $query_acqui -> bindValue(':codassoluto', $data_da_json['codassoluto']);
        $query_acqui -> execute();
        $righe_tabella_acqui = $query_acqui -> fetchAll();

        if (count($righe_tabella_acqui)==0) {
            $quera = $db -> prepare('INSERT INTO techseum.acquisizioni (codassoluto,tipoacquisizione, dasoggetto, quantita,codacquisizione) VALUES (:codassoluto,:tipoacquisizione,:dasoggetto,:quantita,:codacquisizione;');
            $quera -> bindValue(':tipoacquisizione', $data_da_json['tipoacquisizione']);
            $quera -> bindValue(':codassoluto', $data_da_json['codassoluto']);
            $quera -> bindValue(':codacquisizione', $data_da_json['codacquisizione']);
            $quera -> bindValue(':quantita', $data_da_json['quantita']);
            $quera -> bindValue(':dasoggetto', $data_da_json['dasoggetto']);
            $quera->execute();
        }
        else {
            $quera = $db -> prepare('UPDATE techseum.acquisizioni SET tipoacquisizione=:tipoacquisizione, dasoggetto=:dasoggetto, quantita=:quantita,codacquisizione=:codacquisizione  WHERE codassoluto=:codassoluto;');
            $quera -> bindValue(':tipoacquisizione', $data_da_json['tipoacquisizione']);
            $quera -> bindValue(':codassoluto', $data_da_json['codassoluto']);
            $quera -> bindValue(':codacquisizione', $data_da_json['codacquisizione']);
            $quera -> bindValue(':quantita', $data_da_json['quantita']);
            $quera -> bindValue(':dasoggetto', $data_da_json['dasoggetto']);
            $quera->execute();
        }
        
        // QUESTA PARTE MODIFICA MEDIA IN PARTICOLARE NMEDIA PARTENDO DA CODASSOLUTO
        $quedr=$db -> prepare('DELETE FROM techseum.media WHERE codassoluto=:codassoluto;');
        $quedr -> bindValue(':codassoluto', $data_da_json['codassoluto']);
        $quedr->execute();

        for($i=0;$i<count($data_da_json['nmedia']);$i++) {
            $quere = $db -> prepare('INSERT INTO techseum.media(codassoluto,nmedia,tipo,fonte,link) VALUES (:codassoluto,:nmedia,:tipo,:fonte,:link);');
            $quere -> bindValue(':nmedia', $data_da_json['nmedia'][$i]);
            $quere -> bindValue(':codassoluto', $data_da_json['codassoluto']);
            $quere -> bindValue(':tipo', $data_da_json['tipo'][$i]);
            $quere -> bindValue(':link', $data_da_json['link'][$i]);
            $quere -> bindValue(':fonte', $data_da_json['fonte'][$i]);
            $quere->execute();
        }

        // QUESTA PARTE MODIFICA PARTI IN PARTICOLARE IL NOMEPARTE PARTENDO DA CODASSOLUTO
        $quedr=$db -> prepare('DELETE FROM techseum.parti WHERE :codassoluto=codassoluto;');
        $quedr -> bindValue(':codassoluto', $data_da_json['codassoluto']);
        $quedr->execute();

        for ($i=0;$i<count($data_da_json['nparte']);$i++) {
            $queri = $db -> prepare('INSERT INTO techseum.parti(nomeparte,nparte,codassoluto) VALUES (:nomeparte,:nparte,:codassoluto);');
            $queri -> bindValue(':nomeparte', $data_da_json['nomeparte'][$i]);
            $queri -> bindValue(':codassoluto', $data_da_json['codassoluto']);
            $queri -> bindValue(':nparte', $data_da_json['nparte'][$i]);
            $queri->execute();
        }

        // Output dell'API in formato JSON
        echo '{"status":1, "data":"Reperto aggiornato"}';
        exit();
        
    } catch(PDOException $ex) {
        err("Errore nell'esecuzione della query", __LINE__);
    }
