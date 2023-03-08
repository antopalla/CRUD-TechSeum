<script>
    // IMPORT FROM SVELTE
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'

    // IMPORT FROM CARBON
    import { Select, SelectItem } from "carbon-components-svelte";

    // IMPORT FUNZIONI E VARIABILI
    import { url_path } from "../js/const.js"
    import { codmateriale } from "../js/materiale.js"

    // VARIABILI
    let materiali = writable([]);
    let selected = "-1"

    onMount(async() => {
        const url = url_path + '/back-end_development/materiale/get_materiali.php'
        let res = await fetch(url)
        res = await res.json() 

        $materiali = res.data 
    })

    // Update dei campi della select nel momento in cui vine creato un nuovo materiale/modificato
    export async function update () {
        const url = url_path + '/back-end_development/materiale/get_materiali.php'
        let res = await fetch(url)
        res = await res.json() 

        $materiali = res.data
        
        selected = "-1"
    }

</script>
 
<Select hideLabel bind:selected on:change={(e) => $codmateriale = e.target.value}>
    <SelectItem value="-1" text=" -- SELEZIONARE -- " />
    {#each $materiali as materiale}
        <SelectItem value="{materiale.id}" text="{materiale.nomemateriale}" />
    {/each}
</Select>