<script>
    import { Select, SelectItem } from "carbon-components-svelte";
    import { url_path } from "../js/const.js"
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'

    let autori = writable([]);

    onMount(async() => {
        const url = 'http://' + url_path + '/back-end_development/autore/get_autori.php'
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON

        $autori = res.data // Contiene l'array contenuto nell'oggetto; il simbolo $ indica come la variabile sia presa dall'import 
                            // del JavaScript, Variabile Front-End globale per i reperti
        
    })

</script>

<Select hideLabel labelText="Carbon theme" selected="cm">
    {#each $autori as autore}
        <SelectItem value="{autore.id}" text="{autore.nomeautore}" />
    {/each}
</Select>