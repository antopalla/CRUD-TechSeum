<script>
    
    import {Button} from 'flowbite-svelte'
    import {Input} from 'flowbite-svelte'

</script>

<style>

.right {
    position: absolute;
    right: 10px;
    width: 600px;
    border: 0px solid #e6d821;
    padding: 10px;
}
.left{
    position: absolute;
    left: 10px;
    width: 600px;
    border: 0px solid #e6d821;
    padding: 10px;  
}

footer { 
    position: fixed;
    bottom:40px;
    right:40px;
    text-align: center;
    padding: 3px; 
}

</style>

<header>



</header>

<form action="">
    <section class='right'>
        
        <br><Input size="sm" placeholder="Inserire password..." label='Password'/><br><br><br>
        Conferma password <br><Input size="sm" placeholder="Conferma password..." label="Small input"/><br><br><br>
    </section>

    <section class='left'>
        
        Nome <br><Input size="sm" placeholder="Small input" label="Small input"/>
        Cognome <br><Input size="sm" placeholder="Small input" label="Small input"/>
        Username <br><Input size="sm" placeholder="Small input" label="Small input"/>
        Amministratore <br><Input size="sm" placeholder="Small input" label="Small input"/>

    </section>


    <footer>
        <p >  
            <Button outline color='yellow'>Crea Utente</Button>
        </p>
    </footer>

</form>

