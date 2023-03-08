<script>
    // IMPORT FROM CARBON
    import { Row, Column, TextInput } from "carbon-components-svelte";

    // IMPORT FUNZIONI E VARIABILI
    import { form_modifica } from "../js/const.js"
    import { numero_inserimento_parti_m } from "../js/data-select.js"

    // VARIABILI
    export let valore;
    let last_inserted_nomeparte = valore

    // Funzione per inserire nell'array nomeparte (derivante dal form_modifica) i valori presenti nel component
    function inserisci_in_array_nomeparte(e) {
        if (!form_modifica.nomeparte.includes(e.target.value) && form_modifica.nomeparte.length < $numero_inserimento_parti_m) {
            form_modifica.nomeparte.push(e.target.value)
            form_modifica.nparte.push(form_modifica.nomeparte.indexOf(e.target.value))
        }
        else if (form_modifica.nomeparte.includes(last_inserted_nomeparte)) {
            form_modifica.nomeparte[form_modifica.nomeparte.indexOf(last_inserted_nomeparte)] = e.target.value
            form_modifica.nparte.push[form_modifica.nomeparte.indexOf(last_inserted_nomeparte)] = form_modifica.nomeparte.indexOf(e.target.value)
        }
        last_inserted_nomeparte = e.target.value
    }

</script>

<Row>
    <Column>
        <TextInput bind:value={valore} on:blur={inserisci_in_array_nomeparte} hideLabel placeholder="Nomeparte" />
    </Column>
</Row>