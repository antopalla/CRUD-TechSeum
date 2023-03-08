<script>
    // IMPORT FROM SVELTE
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'

    // IMPORT FROM CARBON
    import { Select, SelectItem } from "carbon-components-svelte";

    // IMPORT FUNZIONI E VARIABILI
    import { url_path } from "../js/const.js"
    import { form } from "../js/const.js"

    // VARIABILI
    let autori = writable([]);

    onMount (async() => {
        const url = url_path + '/back-end_development/autore/get_autori.php'
        let res = await fetch(url)
        res = await res.json() 

        $autori = res.data 
    })

</script>

<Select on:change={(e) => form.codautore = e.target.value} hideLabel>
    <SelectItem value="" text=" -- SELEZIONARE -- " />
    {#each $autori as autore}
        <SelectItem value="{autore.id}" text="{autore.nomeautore}" />
    {/each}
</Select>