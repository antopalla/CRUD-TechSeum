<script>
    import { TextInput, PasswordInput } from 'carbon-components-svelte';
    import { Button } from 'carbon-components-svelte';
    import { current_User, login, loggedIn } from "../js/functions.js";
    import { hex_md5 } from "../js/crypto.js";

      // Variabili del form
      const form = {
        username: "",
        password: "",
      };

      // Hash della password
      function codifica() {
        let seme='a5e8c77643355da8c177f741cb202e94';
        return hex_md5(hex_md5(hex_md5(form.password)+seme));
      }

      // Check login con API
      const handleForm = async () => {
          await login(form.username, codifica(form.password));
          console.log(codifica(form.password))
          if ($current_User) {
              $loggedIn = true;
              window.location.replace("/reperti"); // Da aggiustare.....
          }
      };
  
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
    <form on:submit|preventDefault={handleForm}>
      <header>
        LOG IN
      </header>
      <section>
        USERNAME
        <br><br>
        <TextInput bind:value={form.username} placeholder="Inserisci username..." required name='username' />
        <br><br>
        PASSWORD
        <br><br>
        <PasswordInput bind:value={form.password} placeholder="Inserisci password..." required name='password' />
        <br><br>
      </section>
      <p><Button style='background-color:#456266;font-size:20px;padding:10px' type='submit'>Accedi</Button></p>
      
    </form>
  </center>