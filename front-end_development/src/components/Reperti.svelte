<script>
    import {reperti} from '../js/data-reperti.js'
    import {onMount} from 'svelte'
    import Reperto from './Reperto.svelte'
    import {Grid, Row, Column} from "carbon-components-svelte";

    onMount(async() => {
        const url = 'http://localhost:3000/back-end_development/get_reperti.php'
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON

        $reperti = res.data // Contiene l'array contenuto nell'oggetto; il simbolo $ indica come la variabile sia presa dall'import 
                            // del JavaScript, Variabile Front-End globale per i reperti
    })

</script>

<div id = 'reperti'>
    <Grid>
        <Row>
            <Column>CodAssoluto</Column>
            <Column>Nome</Column>
            <Column>Descrizione</Column>
        </Row>
        {#each $reperti as reperto}
            <Reperto {reperto} />
        {/each}
    </Grid>
</div>

