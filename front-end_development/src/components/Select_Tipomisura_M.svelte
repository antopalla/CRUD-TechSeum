<script>
    // IMPORT FROM SVELTE
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'

    // IMPORT FROM CARBON
    import { Select, SelectItem, TextInput, Column, Row } from "carbon-components-svelte";

    // IMPORT FUNZIONI E VARIABILI
    import { url_path } from "../js/const.js"
    import { form_modifica } from "../js/const.js"
    import { numero_select_tipomisure_m } from "../js/data-select.js"


    // VARIABILI
    let misure = writable([]);
    export let valore 
    export let tipomisura
    let last_inserted_valore = valore
    let last_inserted_tipomisura = tipomisura

    onMount(async() => {
        const url = url_path + '/back-end_development/misura/get_misure.php'
        let res = await fetch(url)
        res = await res.json()

        $misure = res.data 
    })

    // Funzione per inserire nell'array valore (derivante dal form_modifica) i valori presenti nel component
    function inserisci_in_array_valore(e) {
        if (!form_modifica.valore.includes(e.target.value) && form_modifica.valore.length < $numero_select_tipomisure_m) {
            form_modifica.valore.push(e.target.value)
        }
        else if (form_modifica.valore.includes(last_inserted_valore)) {
            form_modifica.valore[form_modifica.valore.indexOf(last_inserted_valore)] = e.target.value
        }
        last_inserted_valore = e.target.value
    }

    // Funzione per inserire nell'array valore (derivante dal form_modifica) i valori presenti nel component
    function inserisci_in_array_tipomisura(e) {
        if (!form_modifica.tipomisura.includes(e.target.value) && form_modifica.tipomisura.length < $numero_select_tipomisure_m) {
            form_modifica.tipomisura.push(e.target.value)
        }
        else if (form_modifica.tipomisura.includes(last_inserted_tipomisura)) {
            form_modifica.tipomisura[form_modifica.tipomisura.indexOf(last_inserted_tipomisura)] = e.target.value
        }
        last_inserted_tipomisura = e.target.value
    }

</script>

<Row>
    <Column>
        <TextInput bind:value={valore} on:blur={inserisci_in_array_valore} type="number" step="0.01" hideLabel placeholder="Inserire valore: " />
    </Column>
    <Column>
        <Select selected={tipomisura} on:change={inserisci_in_array_tipomisura} hideLabel>
            <SelectItem value="" text=" -- SELEZIONARE -- " />
            {#each $misure as misura}
                <SelectItem value="{misura.id}" text="{misura.unitadimisura + " (" + misura.nomemisura +")"}" />
            {/each}
        </Select>
    </Column>
</Row>

