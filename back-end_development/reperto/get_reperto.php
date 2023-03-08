<?php
    // API PER L'ESTRAZIONE DI UN REPERTO DAL DATABASE

    require_once(__DIR__.'/../protected/headers.php');
    require_once(__DIR__.'/../protected/functions.php');
    require_once(__DIR__.'/../protected/check_session.php');
    require_once(__DIR__.'/../protected/connessioneDB.php');

    // Utilizzo del try - catch per eventuali errori nella query, BIND per evitare SQL INJECTION
    try {

        //Query per estrarre tutti gli altri valori collegati al reperto

        $query_repertinuova = $db -> prepare('SELECT * FROM techseum.repertinuova WHERE codassoluto=:codassoluto'); 
        $query_repertinuova -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_compostoda = $db -> prepare('SELECT codmateriale FROM techseum.compostoda WHERE codassoluto=:codassoluto'); 
        $query_compostoda -> bindValue(':codassoluto', $_GET['codassoluto']);
        
        $query_lingua = $db -> prepare('SELECT lingua FROM techseum.didascalie WHERE codassoluto=:codassoluto'); 
        $query_lingua -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_didascalie = $db -> prepare('SELECT didascalia FROM techseum.didascalie WHERE codassoluto=:codassoluto'); 
        $query_didascalie -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_tipomisura = $db -> prepare('SELECT tipomisura FROM techseum.misure WHERE codassoluto=:codassoluto'); 
        $query_tipomisura -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_valore = $db -> prepare('SELECT valore FROM techseum.misure WHERE codassoluto=:codassoluto'); 
        $query_valore -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_autore = $db -> prepare('SELECT codautore FROM techseum.hafatto WHERE codassoluto=:codassoluto'); 
        $query_autore -> bindValue(':codassoluto', $_GET['codassoluto']);
        
        $query_tipoacquisizione = $db -> prepare('SELECT tipoacquisizione FROM techseum.acquisizioni WHERE codassoluto=:codassoluto'); 
        $query_tipoacquisizione -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_codacquisizione = $db -> prepare('SELECT codacquisizione FROM techseum.acquisizioni WHERE codassoluto=:codassoluto'); 
        $query_codacquisizione -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_dasoggetto = $db -> prepare('SELECT dasoggetto FROM techseum.acquisizioni WHERE codassoluto=:codassoluto'); 
        $query_dasoggetto -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_quantita = $db -> prepare('SELECT quantita FROM techseum.acquisizioni WHERE codassoluto=:codassoluto'); 
        $query_quantita -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_nomeparte = $db -> prepare('SELECT nomeparte FROM techseum.parti WHERE codassoluto=:codassoluto'); 
        $query_nomeparte -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_nparte = $db -> prepare('SELECT nparte FROM techseum.parti WHERE codassoluto=:codassoluto'); 
        $query_nparte -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_nmedia = $db -> prepare('SELECT nmedia FROM techseum.media WHERE codassoluto=:codassoluto'); 
        $query_nmedia -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_link = $db -> prepare('SELECT link FROM techseum.media WHERE codassoluto=:codassoluto'); 
        $query_link -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_fonte = $db -> prepare('SELECT fonte FROM techseum.media WHERE codassoluto=:codassoluto'); 
        $query_fonte -> bindValue(':codassoluto', $_GET['codassoluto']);

        $query_tipo = $db -> prepare('SELECT tipo FROM techseum.media WHERE codassoluto=:codassoluto'); 
        $query_tipo -> bindValue(':codassoluto', $_GET['codassoluto']);

        //Esecuzione delle query di tutti gli altri valori collegati al reperto

        $query_repertinuova -> execute();

        $query_lingua -> execute();

        $query_didascalie -> execute();

        $query_tipomisura -> execute();

        $query_valore -> execute();

        $query_autore -> execute();

        $query_quantita -> execute();

        $query_tipoacquisizione -> execute();

        $query_codacquisizione -> execute();

        $query_dasoggetto -> execute();

        $query_nomeparte -> execute();

        $query_nparte -> execute();

        $query_compostoda -> execute();

        $query_nmedia -> execute();

        $query_tipo -> execute();

        $query_fonte -> execute();

        $query_link -> execute();

        //Fetch delle query di tutti gli altri valori collegati al reperto

        $righe_tabella_repertinuova=$query_repertinuova -> fetchAll();

        $righe_tabella_lingua=$query_lingua -> fetchAll();

        $righe_tabella_didascalie=$query_didascalie -> fetchAll();

        $righe_tabella_tipomisura=$query_tipomisura -> fetchAll();

        $righe_tabella_valore=$query_valore -> fetchAll();

        $righe_tabella_autore=$query_autore -> fetchAll();

        $righe_tabella_nomeparte=$query_nomeparte -> fetchAll();
        
        $righe_tabella_nparte=$query_nparte -> fetchAll();

        $righe_tabella_compostoda = $query_compostoda -> fetchAll();

        $righe_tabella_tipoacquisizione=$query_tipoacquisizione -> fetchAll();

        $righe_tabella_codacquisizione=$query_codacquisizione -> fetchAll();

        $righe_tabella_dasoggetto=$query_dasoggetto -> fetchAll();

        $righe_tabella_quantita=$query_quantita -> fetchAll();

        $righe_tabella_nmedia=$query_nmedia -> fetchAll();

        $righe_tabella_tipo=$query_tipo -> fetchAll();

        $righe_tabella_fonte=$query_fonte -> fetchAll();

        $righe_tabella_link=$query_link -> fetchAll();

        $autori_appoggio=[];
        $didascalie_appoggio=[];
        $lingue_appoggio=[]; 
        $materiali_appoggio=[];
        $tipomisure_appoggio=[];
        $valori_appoggio=[];
        $nomeparti_appoggio=[];
        $nparti_appoggio=[];
        $link_appoggio=[];
        $fonti_appoggio=[];
        $nmedia_appoggio=[];
        $tipi_appoggio=[];

        foreach($righe_tabella_autore as $p) {
            foreach ($p as $a) {
                array_push($autori_appoggio, $a);
            }
        }
        $autori=[];

        if ((array_key_exists(0, $autori_appoggio))) {
            $autori['codautore']=$autori_appoggio[0];
        }
        else {
            $autori['codautore']="";
        }
        
        foreach($righe_tabella_didascalie as $p) {
            foreach ($p as $a) {
                array_push($didascalie_appoggio, $a);
            }
        }
        $didascalie=[];

        if ((array_key_exists(0, $didascalie_appoggio))) {
            $didascalie['didascalia']=$didascalie_appoggio[0];
        }
        else {
            $didascalie['didascalia']="";
        }

        foreach($righe_tabella_lingua as $p)
        {
            foreach($p as $a)
                array_push($lingue_appoggio,$a);
        }
        $lingue=[];

        if ((array_key_exists(0, $lingue_appoggio))) {
            $lingue['lingua']=$lingue_appoggio[0];
        }
        else {
            $lingue['lingua']="";
        }
    
        foreach($righe_tabella_compostoda as $p)
        {
            foreach($p as $a)
                array_push($materiali_appoggio,$a);
        }
        $materiali=[];
        $materiali['codmateriale']=$materiali_appoggio;

        foreach($righe_tabella_tipomisura as $p)
        {
            foreach($p as $a)
                array_push($tipomisure_appoggio,$a);
        }
        $tipomisure=[];
        $tipomisure['tipomisura']=$tipomisure_appoggio;

        foreach($righe_tabella_valore as $p)
        {
            foreach($p as $a)
                array_push($valori_appoggio,$a);
        }
        $valori=[];
        $valori['valore']=$valori_appoggio;

        foreach($righe_tabella_nomeparte as $p)
        {
            foreach($p as $a)
                array_push($nomeparti_appoggio,$a);
        }
        $nomeparti=[];
        $nomeparti['nomeparte']=$nomeparti_appoggio;

        foreach($righe_tabella_nparte as $p)
        {
            foreach($p as $a)
                array_push($nparti_appoggio,$a);
        }
        $nparti=[];
        $nparti['nparte']=$nparti_appoggio;

        foreach($righe_tabella_link as $p)
        {
            foreach($p as $a)
                array_push($link_appoggio,$a);
        }
        $link=[];
        $link['link']=$link_appoggio;

        foreach($righe_tabella_fonte as $p)
        {
            foreach($p as $a)
                array_push($fonti_appoggio,$a);
        }
        $fonti=[];
        $fonti['fonte']=$fonti_appoggio;

        foreach($righe_tabella_tipo as $p)
        {
            foreach($p as $a)
                array_push($tipi_appoggio,$a);
        }
        $tipi=[];
        $tipi['tipo']=$tipi_appoggio;

        foreach($righe_tabella_nmedia as $p)
        {
            foreach($p as $a)
                array_push($nmedia_appoggio,$a);
        }
        $nmedia=[];
        $nmedia['nmedia']=$nmedia_appoggio;

        $output=json_encode($righe_tabella_repertinuova[0]+$autori+$lingue+$didascalie+$materiali+$tipomisure+$valori+$nparti+$nomeparti+$righe_tabella_codacquisizione[0]+$righe_tabella_tipoacquisizione[0]+$righe_tabella_dasoggetto[0]+$righe_tabella_quantita[0]+$nmedia+$tipi+$link+$fonti);
        $output=str_replace("codassoluto", "id", $output);

        // Output dell'API in formato JSON
        echo $output;
        exit();

    } catch(PDOException $ex) {
        err("Errore nell'esecuzione della query", __LINE__);
    }