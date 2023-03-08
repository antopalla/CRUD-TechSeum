<script>
    // IMPORT FROM SVELTE 
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'

    // IMPORT FROM CARBON
    import { Select, SelectItem, Column, Row } from "carbon-components-svelte";

    // IMPORT FUNZIONI E VARIABILI
    import { url_path } from "../js/const.js"
    import { tipomisura } from "../js/misura.js"

    // VARIABILI
    let misure = writable([]);
    let selected = "-1"

    onMount(async() => {
        const url = url_path + '/back-end_development/misura/get_misure.php'
        let res = await fetch(url)
        res = await res.json() 

        $misure = res.data 
        
    })

    // Update dei campi della select nel momento in cui vine creato un nuovo tipomisura/modificato
    export async function update () {
        const url = url_path + '/back-end_development/misura/get_misure.php'
        let res = await fetch(url)
        res = await res.json() 

        $misure = res.data 
        
        selected = "-1"
    }

</script>

<Row>
    <Column>
        <Select bind:selected on:change={(e) => $tipomisura = e.target.value}>
            <SelectItem value="" text=" -- SELEZIONARE -- " />
            {#each $misure as misura}
                <SelectItem value="{misura.id}" text="{misura.unitadimisura + " (" + misura.nomemisura +")"}" />
            {/each}
        </Select>
    </Column>
</Row>

