<script>
    import { Row, Column, Select, SelectItem, TextInput } from "carbon-components-svelte";
    import { form } from "../js/const.js"
    import { numero_inserimento_parti } from "../js/data-select.js"

    let last_inserted_nparte = ""
    let last_inserted_nomeparte = ""

    function inserisci_in_array_nparte(e) {
        if (!form.nparte.includes(e.target.value) && form.nparte.length < $numero_inserimento_parti) {
            form.nparte.push(e.target.value)
        }
        else if (form.nparte.includes(last_inserted_nparte)) {
            form.nparte[form.valore.indexOf(last_inserted_nparte)] = e.target.value
        }
        last_inserted_nparte = e.target.value
    }

    function inserisci_in_array_nomeparte(e) {
        if (!form.nomeparte.includes(e.target.value) && form.nomeparte.length < $numero_inserimento_parti) {
            form.nomeparte.push(e.target.value)
        }
        else if (form.nomeparte.includes(last_inserted_nomeparte)) {
            form.nomeparte[form.nomeparte.indexOf(last_inserted_nomeparte)] = e.target.value
        }
        last_inserted_nomeparte = e.target.value
    }


</script>

<Row>
    <Column>
        <TextInput on:blur={inserisci_in_array_nparte} hideLabel placeholder="Quantità:" />
    </Column>
    <Column>
        <TextInput on:blur={inserisci_in_array_nomeparte} hideLabel placeholder="Nomeparte:" />
    </Column>
</Row>