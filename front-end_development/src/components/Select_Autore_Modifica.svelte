<script>
    import { Select, SelectItem } from "carbon-components-svelte";
    import { url_path } from "../js/const.js"
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'
    import { codautore } from "../js/autore.js"

    let autori = writable([]);
    let selected = "-1"

    onMount(async() => {
        const url = 'http://' + url_path + '/back-end_development/autore/get_autori.php'
        let res = await fetch(url)
        res = await res.json() 

        $autori = res.data
    })

    export async function update () {
        const url = 'http://' + url_path + '/back-end_development/autore/get_autori.php'
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