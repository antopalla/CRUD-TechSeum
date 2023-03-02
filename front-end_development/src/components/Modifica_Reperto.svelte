<script>
    // IMPORT FROM SVELTE
    import { goto } from  '$app/navigation';
    import { onMount } from 'svelte'

    // IMPORT FROM CARBON
    import { Button } from "carbon-components-svelte";

    // IMPORT VARIABILI FORM E FUNZIONI
    import { assegnaValori, modificaReperto, getCurrentDateTime, resetFormModifica } from "../js/functions.js";
    import { form_modifica } from "../js/const.js";
    import { url_path } from "../js/const.js"
    import { id_reperto } from "../js/id_reperto.js"
    import { numero_select_materiali_m, numero_select_tipomisure_m, numero_inserimento_parti_m } from "../js/data-select.js"

    // IMPORT COMPONENTS
    import Modifica_Reperto_DX from './Modifica_Reperto_DX.svelte';
    import Modifica_Reperto_SX from './Modifica_Reperto_SX.svelte';
    import Header from "./Header.svelte";
    
    // Variabile per il binding per utilizzare la funzione da un component esterno
    let comp;

    // Variabile per caricamento reperto completato
    let loaded

    // Caricamento dati reperto
    onMount (async() => {
        resetFormModifica()
        $numero_select_materiali_m = 0
        $numero_select_tipomisure_m = 0
        $numero_inserimento_parti_m = 0

        const url = url_path + '/back-end_development/reperto/get_reperto.php?codassoluto='+$id_reperto;
        let res = await fetch(url);
        res = await res.text();
        let data = JSON.parse(res)

        assegnaValori(data)

        loaded = true
    })

    // Handle del form e invio dati
    const handleForm = async () => {
        comp.caricaArray()
        form_modifica.datacatalogazione = getCurrentDateTime();

        await modificaReperto(JSON.stringify(form_modifica))

        resetFormModifica()
        $numero_select_materiali_m = 0
        $numero_select_tipomisure_m = 0
        $numero_inserimento_parti_m = 0

        goto("/reperti");
    };
	const seiSicuro = () =>{
		if (confirm("Modificare reperto ?"))
		{ 
			handleForm() 
		}
	};
</script>

<!--  Style CSS -->
<style>
      .button{
    margin: left;
    margin-top: 6%;
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

{#if loaded}
    <form on:submit|preventDefault={seiSicuro}>

        <!-- Button per submit -->
        <div class="button">
            <Button type="submit" kind='tertiary' size='sm' disabled={false}>Modifica reperto</Button>
        </div>

        <!-- Parte sinistra del form -->
        <div style="width: 40%; float: left">
            <Modifica_Reperto_SX bind:this={comp} />
        </div>
        
        <!-- Parte destra del form -->
        <div style="width: 60%; float: right">
            <Modifica_Reperto_DX />
        </div>

    </form>
    
{:else}
    <p>Caricamento in corso...</p>
{/if}
