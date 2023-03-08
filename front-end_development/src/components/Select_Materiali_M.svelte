<script>
    // IMPORT FROM SVELTE 
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'

    // IMPORT FROM CARBON
    import { Select, SelectItem } from "carbon-components-svelte";

    // IMPORT FUNZIONI E VARIABILI
    import { url_path } from "../js/const.js"
    import { form_modifica } from "../js/const.js"
    import { numero_select_materiali_m } from "../js/data-select.js"

    // IMPORT VARIABILI
    let materiali = writable([]);
    export let valore;
    let last_inserted_materiale = valore

    onMount(async() => {
        const url = url_path + '/back-end_development/materiale/get_materiali.php'
        let res = await fetch(url)
        res = await res.json() 

        $materiali = res.data 
        
    })

    // Funzione per inserire nell'array codmateriale (derivante dal form_modifica) i valori presenti nel component
    function inserisci_in_array_codmateriale(e) {
        if (!form_modifica.codmateriale.includes(e.target.value) && form_modifica.codmateriale.length < $numero_select_materiali_m) {
            form_modifica.codmateriale.push(e.target.value)
        }
        else if (form_modifica.codmateriale.includes(last_inserted_materiale)) {
            form_modifica.codmateriale[form_modifica.codmateriale.indexOf(last_inserted_materiale)] = e.target.value
        }
        last_inserted_materiale = e.target.value
    }

</script>

<Select selected={valore} on:change={inserisci_in_array_codmateriale} hideLabel>
    <SelectItem value="" text=" -- SELEZIONARE -- " />
    {#each $materiali as materiale}
        <SelectItem value="{materiale.id}" text="{materiale.nomemateriale}" />
    {/each}
</Select>