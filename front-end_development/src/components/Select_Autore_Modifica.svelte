<script>
    // IMPORT FROM SVELTE
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'

    // IMPORT FROM CARBON
    import { Select, SelectItem } from "carbon-components-svelte";

    // IMPORT FUNZIONI E VARIABILI
    import { url_path } from "../js/const.js"
    import { codautore } from "../js/autore.js"

    // VARIABILI
    let autori = writable([]);
    let selected = "-1"

    onMount (async() => {
        const url = url_path + '/back-end_development/autore/get_autori.php'
        let res = await fetch(url)
        res = await res.json() 

        $autori = res.data
    })

    // Update dei campi della select nel momento in cui vine creato un nuovo autore/modificato
    export async function update () {
        const url = url_path + '/back-end_development/autore/get_autori.php'
        let res = await fetch(url)
        res = await res.json() 

        $autori = res.data 
        selected = "-1"
    }

</script>
 
<Select hideLabel bind:selected on:change={(e) => $codautore = e.target.value}>
    <SelectItem value="-1" text=" -- SELEZIONARE -- " />
    {#each $autori as autore}
        <SelectItem value="{autore.id}" text="{autore.nomeautore}" />
    {/each}
</Select>