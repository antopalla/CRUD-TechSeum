<script>

    import {TextInput,PasswordInput} from 'carbon-components-svelte';
    import {Checkbox,Button} from 'carbon-components-svelte';
    import { creaUtente } from "../js/functions.js";
    import { hex_md5 } from "../js/crypto.js";
    import Menu from './icone/Menu.svelte';
    import {SideNav,SideNavItems,SideNavLink} from "carbon-components-svelte";
    import {ImageLoader, InlineLoading} from "carbon-components-svelte";

    // Variabili del form
    const form = {
        nome: "",
        cognome: "",
        username: "",
        password: "",
        amministratore: 0,
      };

      // Hash della password
      function codifica() {
        let seme='a5e8c77643355da8c177f741cb202e94';
        return hex_md5(hex_md5(hex_md5(form.password)+seme));
      }
    
    // Cambiare il valore del campo amministratore in base alla checkbox
    let checked=false;
    function cambiaAmm(){
        checked=!checked;
        if(checked) {
            document.getElementById('amministratore').value=1;
            form.amministratore = 1
        }
        if(!checked) {
            document.getElementById('amministratore').value=0;
            form.amministratore = 0
        }
    }

    // Controllo password e conferma password
    // Se non sono uguali il bottone 'crea utente' si disattiva
    let invalid=false;
    let invalidText='La password non è corretta';
    function verificaPsw(){
        let psw=document.getElementById('password').value;
        let cnfpsw=document.getElementById('c').value;
        if(psw!=cnfpsw){
            invalid=true;
        }
        if(psw==cnfpsw){
            invalid=false;
        }
    }

    // Passa i dati all'api crea_utente
    const handleForm = async () => {
        console.log(codifica(form.password))
        await creaUtente(form.nome, form.cognome, form.amministratore, form.username, codifica(form.password));
        window.location.replace("/utenti"); // Da aggiustare.....
      };


    let isSideNavOpen = false;
    let iconDescription='Apri Menu';
    function descrizione(){
        isSideNavOpen=!isSideNavOpen;
        if(isSideNavOpen){
            iconDescription='Chiudi Menu';
        }
        else{
            iconDescription='Apri Menu';
        }
    }

</script>

<style>

    section{        
        width: 400px;       
        padding:50px;
    }
    header{
        background-color: #456266;
        padding:50px;
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

<header><strong><center>GESTIONE UTENTI - Creazione</center></strong></header>
<Button icon={Menu} bind:iconDescription tooltipPosition='right' 
        style='color: #456266; background-color: rgb(0,0,0,0);'
        on:click={descrizione} />

    <SideNav bind:isOpen={isSideNavOpen} style='top: 200px'>
      <SideNavItems >
        <SideNavLink text="Reperti"/>
        <SideNavLink text="Utenti" />
        <SideNavLink text="Log Out" />
      </SideNavItems>
    </SideNav>


<div class="logo">
    <ImageLoader src="/logo.png">
        <svelte:fragment slot="loading">
        <InlineLoading />
        </svelte:fragment>
        <svelte:fragment slot="error">An error occurred.</svelte:fragment>
    </ImageLoader>
    </div>

<center>
    <form id="myform" on:submit|preventDefault={handleForm}>
        
        
        
        <div style="display: -webkit-inline-flex;">
            <section>
                NOME
                <TextInput bind:value={form.nome} placeholder="Inserisci nome..." name='nome' id='nome'/> <br><br>
                COGNOME
                <TextInput bind:value={form.cognome} placeholder="Inserisci cognome..." name='cognome' id='cognome'/> <br><br><br>
                <Checkbox  value=0 on:click={cambiaAmm} labelText="AMMINISTRATORE" name='amministratore' id='amministratore' bind:checked/>

            </section>

            <section>
                USERNAME
                <TextInput bind:value={form.username} placeholder="Inserisci username..." required name='username' id='username' /> <br><br>
                PASSWORD
                <TextInput bind:value={form.password} type='password' placeholder="Inserisci password..." required name='password' id='password'/> <br><br>
                <TextInput type='password' on:input={verificaPsw} bind:invalid bind:invalidText placeholder="Conferma password..." required id='c'/>
            </section>
        </div>
        <p><Button type='submit'
            style='background-color:#456266;
                   font-size:20px;
                   padding:20px'
            disabled={invalid}
            >Crea Utente</Button></p>
        
    </form>
</center>