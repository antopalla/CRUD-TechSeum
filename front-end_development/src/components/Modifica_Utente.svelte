<script>
    // IMPORT FROM SVELTE
    import { onMount } from "svelte";
    import { goto } from '$app/navigation';

    // IMPORT FROM CARBON
    import {TextInput,PasswordInput} from 'carbon-components-svelte';
    import {Checkbox,Button} from 'carbon-components-svelte';

    // IMPORT FUNZIONI E VARIABILI
    import { id_utente } from "../js/id_utente.js"; 
    import { hex_md5 } from "../js/crypto.js";
    import { url_path } from "../js/const.js";
    import { modificaUtente,modificaPasswordUtente } from "../js/functions.js";

    // IMPORT COMPONENTS
    import Header from "./Header.svelte";

    // VARIABILI
    let checked=false;
    let lenN,lenC,lenU;
    let cambiaPassword=false;
    let warning=false;
    let warningText='La passwod deve contenere almeno 8 caratteri';

    // Variabili del form
    const form = {
        nome: "",
        cognome: "",
        username: "",
        password: "",
        amministratore: 0,
      };
    
    onMount(async() => {
        const url = url_path + '/back-end_development/utente/get_utente.php?codutente='+$id_utente;
        let res = await fetch(url);
        res = await res.json();
        let utente = res.data;
        
        // Caricamento campi form con dati presenti nel database
        form.nome=utente[0].nome;
        form.cognome=utente[0].cognome;
        form.username=utente[0].username;
        form.amministratore=utente[0].amministratore;
        if(form.amministratore==1)
            checked=true;   
            
        lenN=form.nome.length;
        lenC=form.cognome.length;
        lenU=form.username.length;
    })

    // Hash della password
    function codifica() {
    let seme='a5e8c77643355da8c177f741cb202e94';
    return hex_md5(hex_md5(hex_md5(form.password)+seme));
    }
    
    // Cambiare il valore del campo amministratore in base alla checkbox
    function cambiaAmm(){
        if(!checked) {
            document.getElementById('amministratore').value=1;
            form.amministratore = 1
        }
        else {
            document.getElementById('amministratore').value=0;
            form.amministratore = 0
        }
        console.log(form.amministratore)
    }

    // Controllo lunghezza password
    function controlloPsw(){
        let psw=document.getElementById('password').value;
        if(psw.length<8){
            warning=true;
        }
        if(psw.length>=8 || psw.length==0){
            warning=false;
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
        await modificaUtente(form.nome, form.cognome, form.amministratore, form.username,$id_utente);
        if(cambiaPassword==true){
            await modificaPasswordUtente(codifica(form.password),$id_utente);
        }
        goto("/utenti"); 
      };
    
    // Fa apparire i campi per inserire la nuova password
    function campiPassword (e){
        e.target.style='display:none';
        document.getElementById('campiPsw').style='display:contents;'
        cambiaPassword=true;    
    }

</script>


<style>

    .hide{
        display:none;
    }

     section{        
        width: 400px;       
        padding:50px;
    }

    .header{
        width: 80%;
        padding: 15px;
        background-color: #aba9a9;
        color: #161616;
        font-size: 1.5em;
    }

</style>

<!-- Header -->
<Header/>

<center>

    <div class='header'>
        GESTIONE UTENTI - Modifica
    </div>

    <form id="myform" on:submit|preventDefault={handleForm}>
        
        <div style="display: -webkit-inline-flex;">
            <!-- Campi nome e cognome del form -->
            <section>
                NOME <br><br>
                <TextInput bind:value={form.nome} placeholder="Inserisci nome..." name='nome' id='nome'maxlength='16'
                    oninput="document.getElementById('charCount2').innerHTML = this.value.length"/>
                <div  style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/16</div>
                <div id="charCount2" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenN}</div> <br><br>
                COGNOME <br><br>
                <TextInput bind:value={form.cognome} placeholder="Inserisci cognome..." name='cognome' id='cognome' maxlength='16'
                    oninput="document.getElementById('charCount2').innerHTML = this.value.length"/>
                <div  style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/16</div>
                <div id="charCount2" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenC}</div> <br><br><br>
                <Checkbox on:click={cambiaAmm} labelText="AMMINISTRATORE" name='amministratore' id='amministratore' bind:checked/>

            </section>

            <!-- Campi username e password del form -->
            <section>
                USERNAME <br><br>
                <TextInput bind:value={form.username} placeholder="Inserisci username..." required name='username' id='username' maxlength='32'/>
                <div  style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/32</div>
                <div id="charCount2" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenU}</div>  <br><br>
                <Button kind="ghost" value='ciao' style='display:contents' on:click={campiPassword}>Cambia Password</Button>
                
                <div id='campiPsw' class='hide'>
                NUOVA PASSWORD <br><br>
                <PasswordInput bind:value={form.password} bind:invalid={warning} bind:invalidText={warningText} on:input={controlloPsw} type='password' placeholder="Inserisci password..." bind:required={cambiaPassword} name='password' id='password'/> <br><br>
                <PasswordInput type='password' on:input={verificaPsw} bind:invalid bind:invalidText placeholder="Conferma password..." bind:required={cambiaPassword} id='c'/>
                </div>
            </section>
        </div>

        <!-- Bottone per il submit -->
        <p><Button type='submit'
            style='background-color:#aba9a9;
                   color:black;
                   font-size:20px;
                   padding:20px'
            disabled={invalid}
            >Salva Modifiche</Button></p>
        
    </form>
</center>