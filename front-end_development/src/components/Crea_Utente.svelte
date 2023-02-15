<script>

    import {TextInput,PasswordInput} from 'carbon-components-svelte';
    import {Checkbox,Button} from 'carbon-components-svelte';
    
    //cambiare il valore del campo amministratore in base alla checkbox
    let checked=true;
    function cambiaAmm(){
        checked=!checked;
        if(checked)
            document.getElementById('amministratore').value=1;
        if(!checked)
            document.getElementById('amministratore').value=0;
    }

    //controllo password e conferma password
    //se non sono uguali il bottone 'crea utente' si disattiva
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

    //passa i dati all'api crea_utente
    function invia(){
        var data=new FormData(document.getElementById('myform'));
        fetch('http://localhost:3000/back-end_development/utente/create_utente.php',
            {method:'POST',body: data})
            .then();
    }

</script>

<style>

    section{        
        width: 400px;       
        border: 0px solid #e6d821;
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
    <form action="localhost/CRUD-TechSeum/back-end_development/create_utente.php" method="post">
        
        <header>
            GESTIONE UTENTI - Creazione
        </header>

        <div style="display: -webkit-inline-flex;">
            <section>
                NOME
                <TextInput placeholder="Inserisci nome..." name='nome'/> <br><br>
                COGNOME
                <TextInput placeholder="Inserisci cognome..." name='cognome'/> <br><br><br>
                <Checkbox labelText="AMMINISTRATORE" name='amministratore' value='0'/>
            </section>

            <section>
                USERNAME
                <TextInput placeholder="Inserisci username..." required name='username'/> <br><br>
                PASSWORD
                <PasswordInput placeholder="Inserisci password..." required name='password'/> <br><br>
                <PasswordInput placeholder="Conferma username..." required name='conferma'/>
            </section>
        </div>
        <p><Button 
            style='background-color:#456266;
                   font-size:20px;
                   padding:20px'
            >Crea Utente</Button></p>
        
    </form>
</center>