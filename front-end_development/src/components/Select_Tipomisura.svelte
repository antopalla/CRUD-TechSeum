<script>
    import { Select, SelectItem, TextInput, Column, Row } from "carbon-components-svelte";
    import { url_path } from "../js/const.js"
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'
    import { form } from "../js/const.js"
    import { numero_select_tipomisure } from "../js/data-select.js"

    let misure = writable([]);
    let last_inserted_valore = ""
    let last_inserted_tipomisura = ""

    onMount(async() => {
        const url = 'http://' + url_path + '/back-end_development/misura/get_misure.php'
        let res = await fetch(url)
        res = await res.json() 

        $misure = res.data 
        
    })

    function inserisci_in_array_valore(e) {
        if (!form.valore.includes(e.target.value) && form.valore.length < $numero_select_tipomisure) {
            form.valore.push(e.target.value)
        }
        else if (form.valore.includes(last_inserted_valore)) {
            form.valore[form.valore.indexOf(last_inserted_valore)] = e.target.value
        }
        last_inserted_valore = e.target.value
    }

    function inserisci_in_array_tipomisura(e) {
        if (!form.tipomisura.includes(e.target.value) && form.tipomisura.length < $numero_select_tipomisure) {
            form.tipomisura.push(e.target.value)
        }
        else if (form.tipomisura.includes(last_inserted_tipomisura)) {
            form.tipomisura[form.tipomisura.indexOf(last_inserted_tipomisura)] = e.target.value
        }
        last_inserted_tipomisura = e.target.value
    }

</script>

<Row>
    <Column>
        <TextInput on:blur={inserisci_in_array_valore} type="number"  hideLabel placeholder="Inserire valore: " />
    </Column>
    <Column>
        <Select on:change={inserisci_in_array_tipomisura} hideLabel>
            <SelectItem value="" text=" -- SELEZIONARE -- " />
            {#each $misure as misura}
                <SelectItem value="{misura.id}" text="{misura.unitadimisura + " (" + misura.nomemisura +")"}" />
            {/each}
        </Select>
    </Column>
</Row>

