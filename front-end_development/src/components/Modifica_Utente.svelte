<script>
	import { onMount } from "svelte";
    import { id_utente } from "../js/id_utente.js"; 
    import {TextInput,PasswordInput} from 'carbon-components-svelte';
    import {Checkbox,Button} from 'carbon-components-svelte';
    import { hex_md5 } from "../js/crypto.js";
    import { url_path } from "../js/const.js";
    import Header from "./Header.svelte";
    import { modificaUtente } from "../js/functions.js";
    import { goto } from '$app/navigation';
    
    // Variabili del form
    const form = {
        nome: "",
        cognome: "",
        username: "",
        password: "",
        amministratore: 0,
      };
    
    let checked=false;
    
    onMount(async() => {
        const url = 'http://' + url_path + '/back-end_development/utente/get_utente.php?codutente='+$id_utente;
        let res = await fetch(url);
        res = await res.json();
        let utente = res.data;
        
        
        //caricamento campi form con dati attuali
        form.nome=utente[0].nome;
        form.cognome=utente[0].cognome;
        form.username=utente[0].username;
        form.amministratore=utente[0].amministratore;
        if(form.amministratore==1)
            checked=true;        
    })
    

      // Hash della password
      function codifica() {
        let seme='a5e8c77643355da8c177f741cb202e94';
        return hex_md5(hex_md5(hex_md5(form.password)+seme));
      }
    
    // Cambiare il valore del campo amministratore in base alla checkbox
    
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

    // Passa i dati all'api update_utente
    const handleForm = async () => {
        console.log(codifica(form.password))
        await modificaUtente(form.nome, form.cognome, form.amministratore, form.username, codifica(form.password));
        goto("/utenti"); // Da aggiustare.....
      };


</script>

<style>
     section{        
        width: 400px;       
        padding:50px;
    }
    .header{
        width: 80%;
        padding: 15px;
        background-color: #bab88a;
        color: #161616;
        font-size: 1.5em;
    }
</style>

<Header/>
<center>
    <div class='header'>
        GESTIONE UTENTI - Modifica
    </div>
    <form id="myform" on:submit|preventDefault={handleForm}>
        
        <div style="display: -webkit-inline-flex;">
            <section>
                NOME <br><br>
                <TextInput bind:value={form.nome} placeholder="Inserisci nome..." name='nome' id='nome'/> <br><br>
                COGNOME <br><br>
                <TextInput bind:value={form.cognome} placeholder="Inserisci cognome..." name='cognome' id='cognome'/> <br><br><br>
                <Checkbox  value=0 on:click={cambiaAmm} labelText="AMMINISTRATORE" name='amministratore' id='amministratore' bind:checked/>

            </section>

            <section>
                USERNAME <br><br>
                <TextInput bind:value={form.username} placeholder="Inserisci username..." required name='username' id='username' /> <br><br>
                PASSWORD <br><br>
                <PasswordInput bind:value={form.password} type='password' placeholder="Inserisci password..." required name='password' id='password'/> <br><br>
                <PasswordInput type='password' on:input={verificaPsw} bind:invalid bind:invalidText placeholder="Conferma password..." required id='c'/>
            </section>
        </div>
        <p><Button type='submit'
            style='background-color:#bab88a;
                   color:#161616;
                   font-size:20px;
                   padding:20px'
            disabled={invalid}
            >Salva Modifiche</Button></p>
        
    </form>
</center>