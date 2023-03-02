<script>
    import { Select, SelectItem } from "carbon-components-svelte";
    import { url_path } from "../js/const.js"
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'
    import { form } from "../js/const.js"

    let autori = writable([]);

    onMount(async() => {
        const url = url_path + '/back-end_development/autore/get_autori.php'
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON

        $autori = res.data // Contiene l'array contenuto nell'oggetto; il simbolo $ indica come la variabile sia presa dall'import 
                            // del JavaScript, Variabile Front-End globale per i reperti
        
    })

</script>

<Select on:change={(e) => form.codautore = e.target.value} hideLabel>
    <SelectItem value="" text=" -- SELEZIONARE -- " />
    {#each $autori as autore}
        <SelectItem value="{autore.id}" text="{autore.nomeautore}" />
    {/each}
</Select>