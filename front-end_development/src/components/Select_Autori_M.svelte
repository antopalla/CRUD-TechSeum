<script>
    import { Select, SelectItem } from "carbon-components-svelte";
    import { url_path } from "../js/const.js"
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'
    import { form_modifica } from "../js/const.js"

    let autori = writable([]);
    let selected

    onMount(async() => {
        const url = 'http://' + url_path + '/back-end_development/autore/get_autori.php'
        let res = await fetch(url)
        res = await res.json() 

        $autori = res.data 
        
    })

    export async function update (sel) {
        selected = sel
    }

</script>

<Select bind:selected on:change={(e) => form_modifica.codautore = e.target.value} hideLabel>
    <SelectItem value="" text=" -- SELEZIONARE -- " />
    {#each $autori as autore}
        <SelectItem value="{autore.id}" text="{autore.nomeautore}" />
    {/each}
</Select>