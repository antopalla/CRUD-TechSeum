<script>
    import { Select, SelectItem } from "carbon-components-svelte";
    import { url_path } from "../js/const.js"
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'
    import { codmateriale } from "../js/materiale.js"

    let materiali = writable([]);
    let selected = "-1"

    onMount(async() => {
        const url = 'http://' + url_path + '/back-end_development/materiale/get_materiali.php'
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON

        $materiali = res.data // Contiene l'array contenuto nell'oggetto; il simbolo $ indica come la variabile sia presa dall'import 
                            // del JavaScript, Variabile Front-End globale per i reperti
    })

    export async function update () {
        const url = 'http://' + url_path + '/back-end_development/materiale/get_materiali.php'
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON

        $materiali = res.data // Contiene l'array contenuto nell'oggetto; il simbolo $ indica come la variabile sia presa dall'import 
                            // del JavaScript, Variabile Front-End globale per i reperti
        selected = "-1"
    }

</script>
 
<Select hideLabel bind:selected on:change={(e) => $codmateriale = e.target.value}>
    <SelectItem value="-1" text=" -- SELEZIONARE -- " />
    {#each $materiali as materiale}
        <SelectItem value="{materiale.id}" text="{materiale.nomemateriale}" />
    {/each}
</Select>