<script>
    import {utenti} from '../js/data-utenti.js';
    import {onMount} from 'svelte';
    import {DataTable, Toolbar, ToolbarContent, ToolbarSearch, Button} from "carbon-components-svelte";
    import TrashCan from './icone/Trash_Can.svelte';
    import Add from "./icone/Add_User.svelte";
    import Edit from "./icone/Edit.svelte";

    onMount(async() => {
        const url = 'http://localhost/CRUD-TechSeum/back-end_development/utente/get_utenti.php'
        let res = await fetch(url)
        res = await res.json() 

        $utenti = res.data
        
        // Campo amministratore  0-->'No' 1-->'Sì'
        const formattaAmm = (amm) => { 
          if(amm==1)
            return 'SI';
          else          
            return 'NO';
        }

        // Formatta amministratore per ogni utente
        $utenti.forEach((item) => {
          item.amministratore = formattaAmm(item.amministratore);
        })


        //console.log($utenti)
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

</style>


<header>
  <center><strong>GESTIONE UTENTI - Visualizzazione</strong></center>
</header>

<div id = 'utenti'>
    <DataTable
        size="medium"  
        headers={[ 
            { key: "username", value: "Username" },
            { key: "nome", value: "Nome" },
            { key: "cognome", value: "Cognome" },
            { key: "amministratore", value: "Amministratore" },
            { key: "modifica", empty: true, width:'100px' },
            { key: "elimina", empty: true, width:'100px' }]}
        rows={$utenti}
      >
        <Toolbar >
            <ToolbarContent>
              <ToolbarSearch
                persistent
                shouldFilterRows
                bind:filteredRowIds
              />
              <Button icon={Add} style="background-color: #456266; color: #b3c5c7; " 
                      iconDescription="Aggiungi Utente"
                      tooltipPosition="left"
                      on:click={window.location.replace("/utenti/crea_utente")}/>
            </ToolbarContent>
        </Toolbar>

        <svelte:fragment slot="cell" let:cell>
          {#if cell.key === "modifica"}
            <Button icon={Edit} iconDescription="Modifica"
                    style='color: #456266; background-color: rgb(0,0,0,0);'
                    
                    /> 
          {:else if cell.key==="elimina"}
            <Button icon={TrashCan} iconDescription="Elimina"
                    style='color: #456266; background-color: rgb(0,0,0,0);'
                    />
          {:else}{cell.value}{/if}
        </svelte:fragment>
      </DataTable>
</div>
