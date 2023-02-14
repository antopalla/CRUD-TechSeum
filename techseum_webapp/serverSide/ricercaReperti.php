<?php

  include("base.php");



  /*

     * Funzione che trasforma un array di elementi ottenuti da una select MySQL in una stringa in formato JSON.

     * @param:

     * 	$reperti: Array di elementi (risultato di mysqli_query)

     *

     * @return:

     *  Una stringa in formato JSON che rappresenta l'array (associativo) passato per parametro

  */

  function JSONizzaId($con, $reperti) {

    $numeroReperti = mysqli_num_rows($reperti);

    $JSONCompleto = "";

    $i = 0;

    while($reperto = mysqli_fetch_array($reperti)) {

      $i++;

      $cod = $reperto["codassoluto"];

      $nome = $reperto["nome"];

      $sezione = $reperto["sezione"];

      $codrel = $reperto["codrelativo"];

      $data = $reperto["annoiniziouso"];



      $arrayAutori = array();

      $arrayMisure = array();

      $arrayMateriali = array();

      $arrayDida = array();

      $queryAutori = "SELECT nomeautore FROM hafatto, autore WHERE autore.codautore = hafatto.codautore AND hafatto.codassoluto = $cod";

      $queryDidascalie = "SELECT * FROM `didascalie` WHERE codassoluto = $cod";

      $queryAcqui = "SELECT * FROM `acquisizioni` WHERE codassoluto = $cod";

      $queryMateriali = "SELECT nomemateriale FROM compostoda, materiali WHERE materiali.codmateriale = compostoda.codmateriale AND compostoda.codassoluto = $cod";

      $queryMisure = "SELECT * FROM `misure` a, nomimisure b WHERE a.tipomisura = b.tipomisura AND codassoluto = $cod";

      $queryImmagini = "SELECT COUNT(*) AS numero_media FROM media  GROUP BY codassoluto HAVING codassoluto = $cod";

      $didascalieAssieme = mysqli_query($con, $queryDidascalie);

      $autoriAssieme = mysqli_query($con, $queryAutori);

      $acquiAssieme = mysqli_query($con, $queryAcqui);

      $materialiAssieme = mysqli_query($con, $queryMateriali);

      $misureAssieme = mysqli_query($con, $queryMisure);

      $numeroImmagini = mysqli_query($con, $queryImmagini);

      

      while($autoreSingolo = mysqli_fetch_array($autoriAssieme)) {

        array_push($arrayAutori, $autoreSingolo[0]);

      }


      while($materialeSingolo = mysqli_fetch_array($materialiAssieme)) {

        array_push($arrayMateriali, $materialeSingolo[0]);

      }

      

      while($didascaliaSingola = mysqli_fetch_array($didascalieAssieme)) {

        $codiceDidascalia = $didascaliaSingola[1];

        $arrayDida[$codiceDidascalia] = $didascaliaSingola[2];

      } 

      

      while($acquiSingola = mysqli_fetch_array($acquiAssieme)) {

        $codacqui = $acquiSingola[1];

        $tipoacqui = $acquiSingola[2];

        $dasogg = $acquiSingola[3];

        $quantita = $acquiSingola[4];

      }
      


      while($misuraSingola = mysqli_fetch_assoc($misureAssieme)) {

        $nomeMisura = $misuraSingola["nomemisura"];

        $arrayMisure[$nomeMisura] = $misuraSingola["valore"];

      }

	    

      $tmp = mysqli_fetch_array($numeroImmagini);



      if(isset($tmp["numero_media"])) {

        $nmedia = $tmp["numero_media"];

      }

      else {

        $nmedia = 0;

      }



      $array = array("codassoluto" => $cod, "nome" => $nome, "sezione" => $sezione, "codrelativo" => $codrel, "annoiniziouso" => $data, "autori" => $arrayAutori, "didascalia" => $arrayDida,  "codacquisizione" => $codacqui, "tipoacquisizione" => $tipoacqui,  "dasoggetto" => $dasogg, "quantita" => $quantita, "materiale" => $arrayMateriali, "misura" => $arrayMisure, "nmedia" => $nmedia);

      $JSONParziale = json_encode($array);

      $JSONCompleto .= $JSONParziale;

      

      if($i != $numeroReperti) {

        $JSONCompleto .= ",";

      }

    }

    /*

    /////////////////////////////////////

    $fp = fopen('results.json', 'w');

    fwrite($fp, $JSONCompleto);

    fclose($fp);

    ////////////////////////////////////

    */

    return $JSONCompleto;

  }



	function JSONizzaParziale($con, $reperti) {

      $numeroReperti = mysqli_num_rows($reperti);

      $JSONCompleto = "";

	  $i = 0;

      while($reperto = mysqli_fetch_array($reperti)) {

	    $i++;

        $cod = $reperto["codassoluto"];

        $nome = $reperto["nome"];

        $sezione = $reperto["sezione"];

        $codrel = $reperto["codrelativo"];

        $data = $reperto["annoiniziouso"];



    $arrayAutori = array();

		$queryAutori = "SELECT nomeautore FROM hafatto, autore WHERE autore.codautore = hafatto.codautore AND hafatto.codassoluto = $cod";

		$autoriAssieme = mysqli_query($con, $queryAutori);

		while($autoreSingolo = mysqli_fetch_array($autoriAssieme)) {

			array_push($arrayAutori, $autoreSingolo[0]);

		}

    $array = array("codassoluto" => $cod, "nome" => $nome, "sezione" => $sezione, "codrelativo" => $codrel, "annoiniziouso" => $data, "autori" => $arrayAutori);

    $JSONParziale = json_encode($array);

		$JSONCompleto .= $JSONParziale;

		if($i != $numeroReperti) {

			$JSONCompleto .= ",";

		}

      }

	  

    /*

    /////////////////////////////////////

    $fp = fopen('results.json', 'w');

    fwrite($fp, $JSONCompleto);

    fclose($fp);

    ////////////////////////////////////

    */

      return "[" . $JSONCompleto . "]";

    }





    $con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_NAME) or die("Connessione al server fallita!");

    $stmt = mysqli_stmt_init($con);

    mysqli_set_charset($con, "utf8");

    $id = isset($_GET["id"])?$_GET["id"]:"";

    $parola = isset($_GET["keyword"])?$_GET["keyword"]:"";;

    $sezione = isset($_GET["section"])?$_GET["section"]:"";;

    

    if ($id!=""){

        $query = "SELECT * FROM `repertinuova` WHERE codassoluto = ?";

        $stmt = $con->prepare($query);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $reperti = $stmt->get_result();

        echo JSONizzaId($con, $reperti);

        exit();

    }

    if ($parola!="") {

        $query = "SELECT * FROM `repertinuova` WHERE nome LIKE ?";

        $parola = "%" . $parola . "%";

        $stmt = $con->prepare($query);

        $stmt->bind_param("s", $parola);

        $stmt->execute();

        $reperti = $stmt->get_result();

        echo JSONizzaParziale($con, $reperti);

    }

    if ($sezione!="") {

        $query = "SELECT * FROM `repertinuova` WHERE sezione = ?";

        $stmt = $con->prepare($query);

        $stmt->bind_param("s", $sezione);

        $stmt->execute();

        $reperti = $stmt->get_result();

        echo JSONizzaParziale($con, $reperti);

    }

?>

