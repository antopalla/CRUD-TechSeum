<?php
$querio=$db -> prepare('INSERT INTO techseum.comGEToda(codassoluto,codmateriale) VALUES (:codassoluto,:codmateriale);');
        // $querio -> bindValue(':codmateriale', $_GET['codmateriale'][$i]);
        // $querio -> bindValue(':codassoluto', $codassoluto);
        // $querio -> execute();