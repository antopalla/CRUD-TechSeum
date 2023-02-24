<script>
  import {TextInput, 
          PasswordInput,
          Toggle,
          Theme,
          ImageLoader,
          InlineLoading} from 'carbon-components-svelte';
  import { Button } from 'carbon-components-svelte';
  import { login } from "../js/functions.js";
  import { current_User, loggedIn} from '../js/data-sessione.js'
  import { hex_md5 } from "../js/crypto.js";
  import { goto } from '$app/navigation';
  
  
  import "carbon-components-svelte/css/all.css";
  let theme = "white"; // "white" | "g10" | "g80" | "g90" | "g100"
  let dark_mode_toggled = false;
  let buttonBG='#aba9a9; color:black; '
  let bgColor = "#f1c40e"
  let text_color = "background-color: #aba9a9; color: #161616;"

  const darkModeHandler = () =>{
    dark_mode_toggled = !dark_mode_toggled
    if(dark_mode_toggled){
      theme = "g100"
      buttonBG='#656565; color:white; '
      bgColor = "#393939"
      text_color = "background-color: #656565; color: #white;"
    }
    else{
      theme = "white"
      buttonBG='#aba9a9; color:black; '
      bgColor = "#f1c40e"
      text_color = "background-color: #aba9a9; color: #161616;"
    }		
  }


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


<Theme bind:theme />
<style>
  section{
    width: 400px;
    border: 0px;
    padding: 50px;
  }
  
  @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&display=swap');
  .header_title{
    
    font-family: 'Josefin Sans', sans-serif;
    font-size: 3em ;	
    padding: 20px;
    
  }
  .header{
    justify-content: center;
    display: flex;
    font-family: 'Josefin Sans', sans-serif;
    font-size: 2em ;
    padding: 10px;
    
  }
  .logo{
		position: absolute;
    background: #0000003b;
		right: 0%;
    top:0px;
		padding: 0px;
		width: 130px;
		height: 92px;
    padding-right: 40px;
  
	}

</style>


<center>

<div class="header_title" style="background-color: {bgColor};">
  DI MAGGIO • TECHSEUM
  <div class="logo" >
    <ImageLoader src="/logo.png" >
      <svelte:fragment slot="loading">
        <InlineLoading />
      </svelte:fragment>
      <svelte:fragment slot="error">An error occurred.</svelte:fragment>
    </ImageLoader>
  </div>
</div>

  
<form on:submit|preventDefault={handleForm}>
  <header class="header" style="{text_color}">
    LOG IN
  </header>
  <div>
    <Toggle
      style = {" left: 10% ; height : 50px ; margin: 5px"}			
      size="sm"
      bind:dark_mode_toggled 
      labelA = "White mode"
      labelB = "Dark mode"
      on:toggle = {darkModeHandler}	/>
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
  
  <p><Button style='background-color: {buttonBG} ;font-size:20px;padding:10px' type='submit'>Accedi</Button></p>
  
</form>
</center>