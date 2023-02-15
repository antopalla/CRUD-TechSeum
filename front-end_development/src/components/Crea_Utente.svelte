<script>

    import {TextInput,PasswordInput} from 'carbon-components-svelte';
    import {Checkbox,Button} from 'carbon-components-svelte';
    
    //cambiare il valore del campo amministratore in base alla checkbox
    let checked=false;
    function cambiaAmm(){
        checked=!checked;
        if(checked)
            document.getElementsByName('amministratore').value=1;
        else
            document.getElementsByName('amministratore').value=0;
    }

    //controllo password e conferma password
    //se non sono uguali il bottone 'crea utente' si disattiva
    let invalid=false;
    let invalidText='Le password sono diverse';
    function verificaPsw(){
        let psw=document.getElementById('p').value;
        let cnfpsw=document.getElementById('c').value;
        if(psw!=cnfpsw){
            invalid=true;
        }
        if(psw==cnfpsw){
            invalid=false;
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

</style>


<center>
    <form action="" method="post">
        
        <header>
            GESTIONE UTENTI - Creazione
        </header>

        <div style="display: -webkit-inline-flex;">
            <section>
                NOME
                <TextInput placeholder="Inserisci nome..." name='nome'/> <br><br>
                COGNOME
                <TextInput placeholder="Inserisci cognome..." name='cognome'/> <br><br><br>
                <Checkbox value='0' on:click={cambiaAmm} labelText="AMMINISTRATORE" name='amministratore' bind:checked/>
            </section>

            <section>
                USERNAME
                <TextInput placeholder="Inserisci username..." required name='username'/> <br><br>
                PASSWORD
                <PasswordInput type='text' placeholder="Inserisci password..." required name='password' id='p' /> <br><br>
                <PasswordInput type='text' on:input={verificaPsw} bind:invalid bind:invalidText placeholder="Conferma username..." required name='conferma' id='c'/>
            </section>
        </div>
        <p><Button 
            style='background-color:#456266;
                   font-size:20px;
                   padding:20px'
            disabled={invalid} 
            >Crea Utente</Button></p>
        
    </form>
</center>