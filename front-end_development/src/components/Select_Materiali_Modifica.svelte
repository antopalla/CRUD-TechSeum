<script>
    import { Select, SelectItem } from "carbon-components-svelte";
    import { url_path } from "../js/const.js"
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'
    import { codmateriale } from "../js/materiale.js"

    let materiali = writable([]);
    let selected = "-1"

    onMount(async() => {
        const url = url_path + '/back-end_development/materiale/get_materiali.php'
        let res = await fetch(url)
        res = await res.json() 

        $materiali = res.data 
    })

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