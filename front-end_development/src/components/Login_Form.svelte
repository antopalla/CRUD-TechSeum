<script>
    import { TextInput, PasswordInput } from 'carbon-components-svelte';
    import { Button } from 'carbon-components-svelte';
    import { login } from "../js/functions.js";
    import { current_User, loggedIn} from '../js/data-sessione.js'
    import { hex_md5 } from "../js/crypto.js";
	import { goto } from '$app/navigation';

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
          console.log($current_User["nome"])
          if ($current_User) {
              $loggedIn = true
              console.log($current_User["nome"])
              goto("/reperti")
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