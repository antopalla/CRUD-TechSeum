<?php
    // FUNZIONI PHP

    // Funzione per generare messaggio di errore generico
    function err($message = 'error', $debug = 0) {
        echo '{ "status":0,
                "message":"'.$message.'",
                "debug":'.$debug.'}';
        exit();
    }