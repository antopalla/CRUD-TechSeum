<script>
    import Modifica_dx from './Aggiungi_Reperto_DX.svelte';
    import Modifica_sx from './Aggiungi_Reperto_SX.svelte';
    import Header from "./Header.svelte";
    let comp;

    // API per creazione reperto
    // Import librerie
    import { Button } from "carbon-components-svelte";
    import { creaReperto } from "../js/functions.js";
    import { getCurrentDateTime } from "../js/functions.js";
    import { form } from "../js/const.js";

    // Handle del form e invio dati
    const handleForm = async () => {
        form.datacatalogazione = getCurrentDateTime();
        console.log(form)
        //await creaReperto();
        //goto("/reperti");
    };

</script>

<style>
      .button{
    margin: left;
    margin-top: 75%;
    margin-left: 35%;
    width: 300px;
    height: 300px;
    position: absolute;
  }
</style>

<div>
    <Header />
</div>

<!-- Form del reperto -->
<form on:submit|preventDefault={handleForm}>

    <div style="width: 40%; float: left">
        <Modifica_sx bind:this={comp} />
    </div>
    
    <div style="width: 60%; float: right">
        <Modifica_dx />
    </div>

    <div class="button">
        <Button type="submit" kind='ghost' on:click={comp.caricaArray()}>Aggiungi reperto</Button>
    </div>
</form>