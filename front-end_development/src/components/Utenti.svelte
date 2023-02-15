<script>
    import {utenti} from '../js/data-utenti.js'
    import {onMount} from 'svelte'
    import {DataTable, Toolbar, ToolbarContent, ToolbarSearch} from "carbon-components-svelte"

    onMount(async() => {
        const url = 'http://localhost/CRUD-TechSeum/back-end_development/utente/get_utenti.php'
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON

        $utenti = res.data // Contiene l'array contenuto nell'oggetto; il simbolo $ indica come la variabile sia presa dall'import 
                            // del JavaScript, Variabile Front-End globale per i reperti

        console.log($utenti)
    })

    let filteredRowIds = [];
    $: console.log("filteredRowIds", filteredRowIds);

</script>


<div id = 'utenti'>
    <DataTable
        headers={[
            { key: "username", value: "Username" },
            { key: "nome", value: "Nome" },
            { key: "cognome", value: "Cognome" },
            { key: "amministratore", value: "Amministratore" },
        ]}
        rows={$utenti}
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