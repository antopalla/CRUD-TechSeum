<script>
    // IMPORT FROM SVELTE
    import { goto } from  '$app/navigation';

    // IMPORT FROM CARBON
    import { Button } from "carbon-components-svelte";

    // IMPORT VARIABILI FORM E FUNZIONI
    import { creaReperto, resetForm } from "../js/functions.js";
    import { getCurrentDateTime } from "../js/functions.js";
    import { form } from "../js/const.js";
    import { numero_select_materiali, numero_select_tipomisure, numero_inserimento_parti } from "../js/data-select.js"

    // IMPORT COMPONENTS
    import Aggiungi_Reperto_DX from './Aggiungi_Reperto_DX.svelte';
    import Aggiungi_Reperto_SX from './Aggiungi_Reperto_SX.svelte';
    import Header from "./Header.svelte";
    
    // Variabile per il binding per utilizzare la funzione da un component esterno
    let comp;

    // Handle del form e invio dati
    const handleForm = async () => {
        comp.caricaArray()
        form.datacatalogazione = getCurrentDateTime();
        await creaReperto(JSON.stringify(form))

        resetForm()
        $numero_select_materiali = 0
        $numero_select_tipomisure = 0
        $numero_inserimento_parti = 0
        goto("/reperti");
    };

	const seiSicuro = () =>{
		if (confirm("Aggiungere reperto ?"))
		{ 
			handleForm() 
		}
	};

</script>


<style>
      .button{
    margin: left;
    margin-top: 3%;
    margin-left: 35%;
    width: 180px;
    height: 100px;
    position: absolute;
  }
</style>


<!--  Header -->
<div>
    <Header />
</div>

<!-- Form del reperto -->
<form on:submit|preventDefault={seiSicuro}>

    <!-- Button per submit -->
    <div class="button">
        <Button type="submit" kind='tertiary' size='sm' disabled={false}>Aggiungi reperto</Button>
    </div>

    <!-- Parte sinistra del form -->
    <div style="width: 40%; float: left">
        <Aggiungi_Reperto_SX bind:this={comp} />
    </div>
    
    <!-- Parte destra del form -->
    <div style="width: 60%; float: right">
        <Aggiungi_Reperto_DX />
    </div>

</form>
