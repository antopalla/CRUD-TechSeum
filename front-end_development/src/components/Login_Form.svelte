<script>
    import { TextInput, PasswordInput } from 'carbon-components-svelte';
    import { Button } from 'carbon-components-svelte';
    import { current_User, login, loggedIn } from "../js/functions.js";
    import { ImageLoader, InlineLoading } from "carbon-components-svelte";

      //passa i dati all'api check_login
      const form = {
        username: "",
        password: "",
      };

      // Check login con API
      const handleForm = async () => {
          await login(form.username, form.password);
          if ($current_User) {
            console.log("Accesso effetuato")
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

    .logo{
      padding: 0px;
      width: 115px;
      height:80px;
      position:absolute;
      left:5px;
      top:10px;
    }
  
  
  </style>
  <center>
    <form on:submit|preventDefault={handleForm}>
      <header>
       <strong>
        LOG IN
       </strong>
      </header>
      <div class="logo">
        <ImageLoader src="/logo.png">
          <svelte:fragment slot="loading">
            <InlineLoading />
          </svelte:fragment>
          <svelte:fragment slot="error">An error occurred.</svelte:fragment>
        </ImageLoader>
      </div>
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