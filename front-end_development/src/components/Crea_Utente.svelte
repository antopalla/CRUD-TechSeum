<script>
    // IMPORT FROM SVELTE
    import { goto } from '$app/navigation';

    // IMPORT FROM CARBON
    import {TextInput, PasswordInput, Checkbox, Button} from 'carbon-components-svelte';

    // IMPORT FUNZIONI E VARIABILI
    import { creaUtente } from "../js/functions.js";
    import { hex_md5 } from "../js/crypto.js";

    // IMPORT COMPONENTS
    import Header from "./Header.svelte"

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
    function cambiaAmm() {
        if (!checked) {
            document.getElementById('amministratore').value=1;
            form.amministratore = 1
        }
        else {
            document.getElementById('amministratore').value=0;
            form.amministratore = 0
        }
    }

    // Controllo lunghezza password
    let warning=false;
    let warningText='La passwod deve contenere almeno 8 caratteri';
    function controlloPsw() {
        let psw=document.getElementById('password').value
        if (psw.length<8) {
            warning=true;
        }
        if (psw.length>=8 || psw.length==0) {
            warning=false;
        }
    }

    // Controllo correttezza password e conferma password
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
        await creaUtente (form.nome, form.cognome, form.amministratore, form.username, codifica(form.password));
        goto("/utenti");
      };

</script>


<style>
    .header_title{
      height: 50px;
      background-color: #aba9a9;
      justify-content: center;
      display: flex;
      font-family: 'Josefin Sans', sans-serif;
      font-size: 1.5em ;	
      width: 80%;
      text-align: center;
      line-height: 50px;
	  }

    section{        
        width: 400px;       
        padding:50px;
    }
</style>


<Header />
<center>
    <div class="header_title">GESTIONE UTENTI</div>
</center>

<center>
    <form id="myform" on:submit|preventDefault={handleForm}>
        
        <!-- Div del form -->
        <div style="display: -webkit-inline-flex;">
            <!-- Sezione nome e cognome -->
            <section>
                NOME
                <TextInput bind:value={form.nome} placeholder="Inserisci nome..." name='nome' id='nome' maxlength='16'
                oninput="document.getElementById('charCount2').innerHTML = this.value.length"/>
            <div  style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/16</div>
            <div id="charCount2" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">0</div> <br><br>
                COGNOME
                <TextInput bind:value={form.cognome} placeholder="Inserisci cognome..." name='cognome' id='cognome' maxlength='16'
                    oninput="document.getElementById('charCount2').innerHTML = this.value.length"/>
                <div  style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/16</div>
                <div id="charCount2" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">0</div> <br><br><br>
                <Checkbox  value=0 on:click={cambiaAmm} labelText="AMMINISTRATORE" name='amministratore' id='amministratore' bind:checked/>
            </section>

            <!-- Sezione username e password-->
            <section>
                USERNAME
                <TextInput bind:value={form.username} placeholder="Inserisci username..." required name='username' id='username' maxlength='32'/>
                <div  style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/32</div>
                <div id="charCount2" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">0</div>  <br><br>
                PASSWORD
                <PasswordInput bind:value={form.password} bind:invalid={warning} bind:invalidText={warningText} on:input={controlloPsw} minlength='8' type='password' placeholder="Inserisci password..." required name='password' id='password'/> <br><br>
                <PasswordInput type='password' on:input={verificaPsw} bind:invalid bind:invalidText placeholder="Conferma password..." required id='c'/>
            </section>
        </div>

        <!-- Bottone del submit -->
        <p><Button type='submit'
            style="background-color:#aba9a9;
                   color:black;
                   font-size:20px;
                   padding:20px"
            disabled={invalid}
            >Crea Utente</Button></p>
            
    </form>
</center>