<script>
    import { utenti } from '../js/data-utenti.js';
    import { url_path } from "../js/const.js"
    import { onMount } from 'svelte';
    import { goto } from "$app/navigation";
    import {DataTable, Toolbar, ToolbarContent, ToolbarSearch, Button} from "carbon-components-svelte";

    import Header from "./Header.svelte"

    import TrashCan from './icone/Trash_Can.svelte';
    import Add from "./icone/Add_User.svelte";
    import Edit from "./icone/Edit.svelte";
	  import { id_utente } from '../js/id_utente.js';
 
    onMount (async() => {
        const url = url_path + '/back-end_development/utente/get_utenti.php'
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
    })

    function redirectToCreaUtente() {
		  goto("/utenti/crea_utente")
	  }

    let filteredRowIds = []; //contiene gli id degli elementi cercati
    $: console.log("filteredRowIds", filteredRowIds);

	let dataTableStyle = "padding:0px;"
</script>

<style>

	@import url('https://fonts.googleapis.com/css2?family=Phudu:wght@900&display=swap');
    
    .header_title{
      height: 50px;
      background-color: #aba9a9;
      justify-content: center;
      display: flex;
      font-family: 'Josefin Sans', sans-serif;
      font-size: 1.5em ;	
      width: 80%;
      text-align: center;
      line-height: 50px;
	  }
    .utenti{
      width: 80%;
      display: flex;
      justify-content: center;

	}
      
</style>

<Header />
<center>
    <div class='header_title'>
       GESTIONE UTENTI 
    </div>


<div id = 'utenti'>
  <div class="utenti">
    <DataTable style = {dataTableStyle}
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
              />
              <Button icon={Add} style="background-color: #aba9a9; " 
                      iconDescription="Aggiungi Utente"
                      tooltipPosition="left"
                      on:click={redirectToCreaUtente}/>
            </ToolbarContent>
        </Toolbar>

        <svelte:fragment slot="cell" let:cell let:row>
          {#if cell.key === "modifica"}
            <Button icon={Edit} iconDescription="Modifica"
                    style='color: #656565; background-color: rgb(0,0,0,0);'
                    on:click={()=>{
                      $id_utente=row.id;
                      goto('utenti/modifica_utente')
                    }}
                    /> 
          {:else if cell.key === "elimina"}
            <Button icon={TrashCan} iconDescription="Elimina"
                    style='color: #656565; background-color: rgb(0,0,0,0);'
                    on:click = {()=>
                      {
                        let idRiga = row.id
                        var xmlHttp = new XMLHttpRequest();
                        xmlHttp.open('GET', url_path + '/back-end_development/utente/delete_utente.php?codutente='+idRiga , false ); // false per richieste sincrone
                        //cancella utente selezionato in base all'id 
                        xmlHttp.send( null );
                        $utenti = $utenti.filter((row) => row.id != idRiga);
                      }	
                    }
                    />
          {:else}{cell.value}{/if}
        </svelte:fragment>
      </DataTable>
      </div>
</div>
</center>
