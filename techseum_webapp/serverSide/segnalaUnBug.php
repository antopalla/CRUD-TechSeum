<?php
  include("base.php");
  $json = file_get_contents('php://input');
  $data = json_decode($json);
  $testoEmail = "Nome: " . $data->nome;
  $testoEmail .= "\nIndirizzo email: " . $data->indirizzoEmail;
  $testoEmail .= "\nCorpo messaggio:\n" . $data->testoEmail;
  $oggetto = "SEGNALAZIONE BUG DI MAGGIO TECH SEUM - " . $data->oggettoEmail;
  if(mail($EMAIL_PER_BUG, $oggetto, $testoEmail))
    echo "Mail inviata correttamente!";
  else
    echo "ERRORE!";
