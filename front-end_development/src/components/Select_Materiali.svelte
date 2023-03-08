<script>
    // IMPORT FROM SVELTE
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'

    // IMPORT FROM CARBON
    import { Select, SelectItem } from "carbon-components-svelte";

    // IMPORT FUNZIONI E VARIABILI
    import { url_path } from "../js/const.js"
    import { form } from "../js/const.js"
    import { numero_select_materiali } from "../js/data-select.js"

    // IMPORT VARIABILI
    let materiali = writable([]);
    let last_inserted = ""

    onMount(async() => {
        const url = url_path + '/back-end_development/materiale/get_materiali.php'
        let res = await fetch(url)
        res = await res.json() 

        $materiali = res.data 
        
    })

    // Funzione per inserire nell'array codmateriale (derivante dal form) i valori presenti nel component
    function inserisci_in_array_codmateriale(e) {
        if (!form.codmateriale.includes(e.target.value) && form.codmateriale.length < $numero_select_materiali) {
            form.codmateriale.push(e.target.value)
        }
        else if (form.codmateriale.includes(last_inserted)) {
            form.codmateriale[form.codmateriale.indexOf(last_inserted)] = e.target.value
        }
        last_inserted = e.target.value
    }

</script>

<Select on:change={inserisci_in_array_codmateriale} hideLabel>
    <SelectItem value="" text=" -- SELEZIONARE -- " />
    {#each $materiali as materiale}
        <SelectItem value="{materiale.id}" text="{materiale.nomemateriale}" />
    {/each}
</Select>