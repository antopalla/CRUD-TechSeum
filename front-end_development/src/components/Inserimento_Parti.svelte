<script>
    // IMPORT FROM CARBON
    import { Row, Column, TextInput } from "carbon-components-svelte";

    // IMPORT FUNZIONI E VARIABILI
    import { form } from "../js/const.js"
    import { numero_inserimento_parti } from "../js/data-select.js"
    
    // VARIABILI
    let last_inserted_nomeparte = ""

    // Funzione per inserire nell'array nomeparte (derivante dal form) i valori presenti nel component
    function inserisci_in_array_nomeparte(e) {
        if (!form.nomeparte.includes(e.target.value) && form.nomeparte.length < $numero_inserimento_parti) {
            form.nomeparte.push(e.target.value)
            form.nparte.push(form.nomeparte.indexOf(e.target.value))
        }
        else if (form.nomeparte.includes(last_inserted_nomeparte)) {
            form.nomeparte[form.nomeparte.indexOf(last_inserted_nomeparte)] = e.target.value
            form.nparte.push[form.nomeparte.indexOf(last_inserted_nomeparte)] = form.nomeparte.indexOf(e.target.value)
        }
        last_inserted_nomeparte = e.target.value
    }

</script>

<Row>
    <Column>
        <TextInput on:blur={inserisci_in_array_nomeparte} hideLabel placeholder="Nomeparte" />
    </Column>
</Row>