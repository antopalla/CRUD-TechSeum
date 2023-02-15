<script>
    import { TextInput, PasswordInput } from 'carbon-components-svelte';
    import { Button } from 'carbon-components-svelte';
    import {utenti} from '../js/data-utenti.js'
    function checkData() {
    let username_db=utenti.username
    let password_db=utenti.password
    if (username_db !== 'username' && password_db !== 'password') {
      // l'username inserito è corretto, si può procedere
      console.log("l'username o password errate");
      // qui si può inserire la logica per inviare i dati alla pagina PHP
    } else {
      // l'username inserito è errato, si mostra un messaggio di errore
      console.log("accesso eseguito");
    }
  }


  </script>
  
  <style>
    section{
      width: 400px;
      border: 0px solid #e6d821;
      padding: 50px;
    }
  
    header {
      background-color: #456266;
      padding: 50px;
      font-size: 35px;
      color: #b3c5c7;
    }
  
  </style>
  
  <center>
    <form action="localhost/CRUD-TechSeum/back-end_development/get_utente.php" method="post">
      <header>
        LOG IN
      </header>
      <section>
        USERNAME
        <br><br>
        <TextInput placeholder="Inserisci username..." required name='username' />
        <br><br>
        PASSWORD
        <br><br>
        <PasswordInput placeholder="Inserisci password..." required name='password' />
        <br><br>
      </section>
      <p><Button style='background-color:#456266;font-size:20px;padding:10px' on:submit={checkData} >Accedi</Button></p>
      
    </form>
  </center>