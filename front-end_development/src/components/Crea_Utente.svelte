<script>

    import {TextInput,PasswordInput} from 'carbon-components-svelte';
    import {Checkbox,Button} from 'carbon-components-svelte';
    import { creaUtente } from "../js/functions.js";
    import { hex_md5 } from "../js/crypto.js";

    // Variabili del form
    const form = {
        nome: "",
        cognome: "",
        username: "",
        password: "",
        amministratore: 1,
      };

      // Hash della password
      function codifica() {
        let seme='a5e8c77643355da8c177f741cb202e94';
        return hex_md5(hex_md5(hex_md5(form.password)+seme));
      }
    
    // Cambiare il valore del campo amministratore in base alla checkbox
    let checked=true;
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
    
</style>


<center>
    <form id="myform" on:submit|preventDefault={handleForm}>
        
        <header>
            GESTIONE UTENTI - Creazione
        </header>

        <div style="display: -webkit-inline-flex;">
            <section>
                NOME
                <TextInput bind:value={form.nome} placeholder="Inserisci nome..." name='nome' id='nome'/> <br><br>
                COGNOME
                <TextInput bind:value={form.cognome} placeholder="Inserisci cognome..." name='cognome' id='cognome'/> <br><br><br>
                <Checkbox  value=1 on:click={cambiaAmm} labelText="AMMINISTRATORE" name='amministratore' id='amministratore' bind:checked/>
            </section>

            <section>
                USERNAME
                <TextInput bind:value={form.username} placeholder="Inserisci username..." required name='username' id='username' /> <br><br>
                PASSWORD
                <PasswordInput bind:value={form.password} type='text' placeholder="Inserisci password..." required name='password' id='password'/> <br><br>
                <PasswordInput type='text' on:input={verificaPsw} bind:invalid bind:invalidText placeholder="Conferma password..." required id='c'/>
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