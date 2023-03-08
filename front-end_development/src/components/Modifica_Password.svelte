<script>
    // IMPORT FROM SVELTE
    import { goto } from '$app/navigation';

    // IMPORT FROM CARBON
    import {PasswordInput, Button} from 'carbon-components-svelte';

    // IMPORT FUNZIONI E VARIABILI
    import {current_User} from '../js/data-sessione.js';
    import {modificaPasswordUtente} from '../js/functions.js';
    import { hex_md5 } from "../js/crypto.js";

    // IMPORT COMPONENTS
    import Header from "./Header.svelte";

    // VARIABILI
    let warning=false;
    let warningText='La passwod deve contenere almeno 8 caratteri';
    let invalid=false;
    let invalidText='La password non è corretta';

    // Variabili del form
    const form={
        password:''
    }

    // Codifica password hash
    function codifica() {
        let seme='a5e8c77643355da8c177f741cb202e94';
        return hex_md5(hex_md5(hex_md5(form.password)+seme));
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

    // Verifica se le due password corrispondono
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

    // Handle del form
    const handleForm = async () =>{
        await modificaPasswordUtente(codifica(form.password),$current_User.id);
        goto("/reperti");
    }

</script>


<style>
    section{        
        width: 400px;       
        padding:50px;
    }

</style>

<!-- Header -->
<Header/>

<center>
    <form on:submit|preventDefault={handleForm}>

        <!-- Form password -->
        <section>
        NUOVA PASSWORD <br><br>
        <PasswordInput bind:value={form.password} bind:invalid={warning} bind:invalidText={warningText} on:input={controlloPsw}
                    placeholder="Inserisci password..." required name='password' id='password'/> <br><br>

        <PasswordInput type='password' on:input={verificaPsw} bind:invalid bind:invalidText
                    placeholder="Conferma password..." required id='c'/>
        </section>

        <!-- Bottone per il submit -->
        <p><Button type='submit'
            style='background-color:#aba9a9;
                color:black;
                font-size:20px;
                padding:20px'
            disabled={invalid}
            >Salva</Button></p>
            
    </form>
</center>