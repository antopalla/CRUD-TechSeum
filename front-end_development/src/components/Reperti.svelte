<script>
    import {reperti} from '../js/data-reperti.js'
    import {onMount} from 'svelte'

    import {
        DataTable,
        Toolbar,
        ToolbarContent,
        ToolbarSearch,
        Pagination,
    } from "carbon-components-svelte";

    onMount(async() => {
        const url = 'http://localhost:3000/back-end_development/get_reperti.php'
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON

        $reperti = res.data // Contiene l'array contenuto nell'oggetto; il simbolo $ indica come la variabile sia presa dall'import 
                            // del JavaScript, Variabile Front-End globale per i reperti

        console.log($reperti)
    })

    let filteredRowIds = [];
    $: console.log("filteredRowIds", filteredRowIds);

</script>

<div id = 'reperti'>
    <DataTable
        headers={[
            { key: "nome", value: "Nome" },
            { key: "definizione", value: "Definizione" },
            { key: "datacatalogazione", value: "Data Catalogazione" },
            { key: "modouso", value: "Modo d'uso" },
            { key: "scopo", value: "Scopo" },
        ]}
        rows={$reperti}
        >
        <Toolbar>
            <ToolbarContent>
              <ToolbarSearch
                persistent
                shouldFilterRows
                bind:filteredRowIds
              />
            </ToolbarContent>
        </Toolbar>
    </DataTable>
</div>

