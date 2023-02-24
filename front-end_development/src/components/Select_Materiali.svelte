<script>
    import { Select, SelectItem } from "carbon-components-svelte";
    import { url_path } from "../js/const.js"
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'
    import { form } from "../js/const.js"
    import { numero_select_materiali } from "../js/data-select.js"

    let materiali = writable([]);
    let last_inserted = ""

    onMount(async() => {
        const url = 'http://' + url_path + '/back-end_development/materiale/get_materiali.php'
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON

        $materiali = res.data // Contiene l'array contenuto nell'oggetto; il simbolo $ indica come la variabile sia presa dall'import 
                            // del JavaScript, Variabile Front-End globale per i materiali
        
    })

    function inserisci_in_array_codmateriale(e) {
        if (!form.codmateriale.includes(e.target.value) && form.codmateriale.length < $numero_select_materiali) {
            form.codmateriale.push(e.target.value)
        }
        else if (form.codmateriale.includes(last_inserted)) {
            form.codmateriale[form.codmateriale.indexOf(last_inserted)] = e.target.value
        }
        last_inserted = e.target.value
    }

</script>

<Select on:change={inserisci_in_array_codmateriale} hideLabel>
    <SelectItem value="" text=" -- SELEZIONARE -- " />
    {#each $materiali as materiale}
        <SelectItem value="{materiale.id}" text="{materiale.nomemateriale}" />
    {/each}
</Select>