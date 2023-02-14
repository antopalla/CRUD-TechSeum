<script>

    import {TextInput,PasswordInput} from 'carbon-components-svelte';
    import {Checkbox,Button} from 'carbon-components-svelte';
    
    let {checked}=false;

</script>

<style>

    section{
        position: absolute;
        right: 200px;     
        width: 500px;       
        border: 0px solid #e6d821;
        padding-top: 50px;
    }
    .right{
        right: 200px;     
        border-right: 1px #e6d821;     
    }

    .left{
        left: 200px;   
        border-left: 1px #e6d821;  
    }

    /*footer{
        position: fixed;
        bottom: 50px;
        right: 50px;
        background-color: #d4c821;
    }*/


</style>


<br><br>

<form action="localhost/CRUD-TechSeum/back-end_development/create_utente.php" method="post">
    <section class='left'>
        
        NOME
        <TextInput placeholder="Inserisci nome..." name='nome'/> <br><br>
        COGNOME
        <TextInput placeholder="Inserisci cognome..." name='cognome'/> <br><br>
        <Checkbox labelText="AMMINISTRATORE" name='amministratore' value='0'/>
    </section>

    <section class='right'>
        USERNAME
        <TextInput placeholder="Inserisci username..." required name='username'/> <br><br>
        PASSWORD
        <PasswordInput placeholder="Inserisci password..." required name='password'/> <br><br>
        <PasswordInput placeholder="Conferma username..." required/>
    </section>

    <center style="bottom:50px;">
        <Button style='background-color:#d4c821;'>Crea Utente</Button>
    </center>

</form>

