<script>
    import {utenti} from '../js/data-utenti.js';
    import {onMount} from 'svelte';
    import {DataTable, Toolbar, ToolbarContent, ToolbarSearch, OverflowMenu , OverflowMenuItem , Button,} from "carbon-components-svelte";
    import { ImageLoader, InlineLoading } from "carbon-components-svelte";
    onMount(async() => {
        const url = 'http://localhost:3000/back-end_development/utente/get_utenti.php'
        let res = await fetch(url)
        res = await res.json() 

        $utenti = res.data 
        console.log($utenti)
    })

    let filteredRowIds = [];
    $: console.log("filteredRowIds", filteredRowIds);

</script>

<style>

    header{
        background-color: #456266;
        padding:50px;
        font-size: 35px;
        color: #b3c5c7;
    }

    .logo{
      padding: 0px;
      width: 115px;
      height:80px;
      position:absolute;
      left:5px;
      top:10px;
    }


</style>
<center>
    <header>
    GESTIONE UTENTI - Visualizzazione
    </header>
    <div class="logo">
      <ImageLoader src="/logo.png">
        <svelte:fragment slot="loading">
          <InlineLoading />
        </svelte:fragment>
        <svelte:fragment slot="error">An error occurred.</svelte:fragment>
      </ImageLoader>
    </div>
</center>

<div id = 'utenti'>
    <DataTable
        size="medium"  
        headers={[ 
            { key: "username", value: "Username" },
            { key: "nome", value: "Nome" },
            { key: "cognome", value: "Cognome" },
            { key: "amministratore", value: "Amministratore" },
            { key: "overflow", empty: true },
        ]}
        rows={$utenti}
        >
        <Toolbar >
            <ToolbarContent>
              <ToolbarSearch
                persistent
                shouldFilterRows
                bind:filteredRowIds
              />
              <Button style="background-color: #456266">Aggiungi Utente</Button>
            </ToolbarContent>
        </Toolbar>

        <svelte:fragment slot="cell" let:cell>
          {#if cell.key === "overflow"}
            <OverflowMenu flipped>
              <OverflowMenuItem text= "Modifica" />
              <OverflowMenuItem danger text= "Elimina" />
            </OverflowMenu>
          {:else}{cell.value}{/if}
        </svelte:fragment>

      </DataTable>
</div>