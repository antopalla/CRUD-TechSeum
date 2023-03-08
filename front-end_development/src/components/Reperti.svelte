<script>
	// IMPORT FROM SVELTE
	import {onMount} from 'svelte'
	import { goto } from "$app/navigation";

	// IMPORT FROM CARBON
	import {DataTable, Toolbar, ToolbarContent, ToolbarSearch, ToolbarBatchActions, Button} from "carbon-components-svelte"
	import TrashCan from "carbon-icons-svelte/lib/TrashCan.svelte";
	import ChartCustom from "carbon-icons-svelte/lib/ChartCustom.svelte";
	import Add from "carbon-icons-svelte/lib/Add.svelte";

	// IMPORT VARIABILI E FUNZIONI
	import { reperti } from '../js/data-reperti.js'
	import { url_path } from "../js/const.js"
	import { id_reperto } from '../js/id_reperto.js';

	// IMPORT COMPONENTS
    import Header from './Header.svelte'
    
	onMount (async() => {
        const url = url_path + '/back-end_development/reperto/get_reperti.php'
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON

        $reperti = res.data // Contiene l'array contenuto nell'oggetto; il simbolo $ indica come la variabile sia presa dall'import 
                            // del JavaScript, Variabile Front-End globale per i reperti
	
		// Funzione per formattare la data
		const formattaData = (data) => {
			if (data != null) {
				data = data.split(" ")
				data = data[0].split("-")
				return data[2]+" "+data[1]+" "+data[0] //riordina data giorno mese anno 
			}
		}

		// Formatta la data per ogni reperto
		$reperti.forEach((item) => {
			item.datacatalogazione = formattaData(item.datacatalogazione)
		})
        
    })

    let filteredRowIds = []; // Contiene gli id degli elementi cercati
    $: console.log("filteredRowIds", filteredRowIds);

	 let selectedRowIds = []; // Contiene l'id dell'elemento selezionato
	$: console.log("selectedRowIds", selectedRowIds);

	// Funzione per il redirect ad aggiungi reperto
	function redirectAggReperto () {
		goto("/reperti/aggiungi_reperto")
	}

</script>


<style>
	@import url('https://fonts.googleapis.com/css2?family=Phudu:wght@900&display=swap');

	.container{
		justify-content: center;
		display: flex;
	}

	.reperti{
		width: 80%;
		display: flex;
		justify-content: center;
	}

</style>


<!-- Header -->
<Header />

<div id = 'reperti' class="container">
    <div class="reperti">	

		<!-- Tabella reperti -->
		<DataTable
			style="padding-top : 0 ; height: 100%;"
			bind:selectedRowIds
			sortable
			size="medium"
			headers={[
				{ key: "nome", value: "Nome", width : "19%",minWidth: "100px"},
				{ key: "sezione", value: "Sezione" ,width : "15%", minWidth:"200px"},
				{ key: "nomeautore", value: "Autore", width: "15%" , minWidth:"200px"},
				{ key: "scopo", value: "Scopo" ,width: "25%" ,minWidth:"200px"},
				{ key: "datacatalogazione", value: "Data Catalogazione",width : "12%", minWidth:"200px"},
				{ key: "modifica", empty: true, width:'5%' },
				{ key: "elimina", empty: true, width:'5%' }
			]}
			rows={$reperti}
			>

			<!-- Barra multifunzione della tabella reperti-->
			<Toolbar size="small" style="border-top: 2px solid #e0e0e0;">

				<!-- Contenuto della barra multifunzione-->
				<ToolbarContent>
					<ToolbarSearch 						
						shouldFilterRows
					/>

					<!-- Bottone per aggiungere un reperto-->
					<Button 
						icon = {Add}
						iconDescription = "Aggiungi reperti"
						kind = "ghost"	
						on:click = {redirectAggReperto}
					/>
				</ToolbarContent>
			</Toolbar>

			<!-- Prendere l'id della riga desiderata e dalla cella la funzione da svolgere da utilizzare (modifica o eliminazione) -->
			<svelte:fragment slot="cell" let:cell let:row>

			<!-- Se la cella selezionata è l'icona di modifica, modifica l'elemento -->
			{#if cell.key === "modifica"}
				<Button 
					kind="ghost"
					icon={ChartCustom} iconDescription="Modifica"
                    on:click={()=>{
						$id_reperto=row.id;
                      	goto('reperti/modifica_reperto')
                    }}
                    /> 

			<!-- Se la cella selezionata è l'icona dell'eliminazione, elimina l'elemento -->
			{:else if cell.key === "elimina"}
				<Button icon={TrashCan} iconDescription="Elimina"
					kind="ghost"
					on:click = {()=>{
						            let idRiga = row.id
									var xmlHttp = new XMLHttpRequest();
									xmlHttp.open('POST', url_path + '/back-end_development/reperto/delete_reperto.php?' , false); // false per richieste sincrone
									xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
									var params = "codassoluto=" + idRiga
									//cancella reperto selezionato in base all id 
									xmlHttp.send( params );
									$reperti = $reperti.filter((row) => row.id != idRiga );
									//rimuove il reperto dalla tabella grafica 	
									selectedRowIds = [];
								}}
				/>

			{:else}{cell.value}{/if}
			</svelte:fragment>

		<!-- Fine tabella -->
		</DataTable>
	</div>
</div>
