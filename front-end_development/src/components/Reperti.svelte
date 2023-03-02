<script>
    import {reperti} from '../js/data-reperti.js'
	import { url_path } from "../js/const.js"
    import {onMount} from 'svelte'
	import { goto } from "$app/navigation";
	import { id_reperto } from '../js/id_reperto.js';

    import {
		DataTable, 
		Toolbar, 
		ToolbarContent, 
		ToolbarSearch,
		ToolbarBatchActions,
		Button
	} from "carbon-components-svelte"

    import Header from './Header.svelte'
	import TrashCan from "carbon-icons-svelte/lib/TrashCan.svelte";
	import ChartCustom from "carbon-icons-svelte/lib/ChartCustom.svelte";
	import Add from "carbon-icons-svelte/lib/Add.svelte";
    
	onMount(async() => {
        const url = url_path + '/back-end_development/reperto/get_reperti.php'
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON

        $reperti = res.data // Contiene l'array contenuto nell'oggetto; il simbolo $ indica come la variabile sia presa dall'import 
                            // del JavaScript, Variabile Front-End globale per i reperti
	
		const formattaData = (data) => {
			if (data != null) {
				data = data.split(" ")
				data = data[0].split("-")
				return data[2]+" "+data[1]+" "+data[0] //riordina data giorno mese anno 
			}
		}

		$reperti.forEach((item) => {
			item.datacatalogazione = formattaData(item.datacatalogazione)
		})// formatta data per ogni reperto
        
    })

    let filteredRowIds = []; //contiene gli degli elementi cercati
    $: console.log("filteredRowIds", filteredRowIds);

	 let selectedRowIds = []; //contiene id dell'elemento selezionato
	$: console.log("selectedRowIds", selectedRowIds);

	function redirectAggReperto () {
		goto("/reperti/aggiungi_reperto")
	}

</script>

<Header />

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

<div id = 'reperti' class="container">
    <div class="reperti">	
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
			<Toolbar size="small" style="border-top: 2px solid #e0e0e0;">
				<ToolbarContent>
					<ToolbarSearch 						
						shouldFilterRows
					/>
					<Button 
						icon = {Add}
						iconDescription = "Aggiungi reperti"
						kind = "ghost"	
						on:click = {redirectAggReperto}
					/>
					<ToolbarBatchActions>
						<Button
							icon = {TrashCan}
							
						>Rimuovi
						</Button>
						
						<Button
							icon = {ChartCustom}
							>
							Modifica
						</Button>
					</ToolbarBatchActions>	
				</ToolbarContent>
			</Toolbar>
			<svelte:fragment slot="cell" let:cell let:row>
			{#if cell.key === "modifica"}
				<Button 
					kind="ghost"
					icon={ChartCustom} iconDescription="Modifica"
                    on:click={()=>{
						$id_reperto=row.id;
                      	goto('reperti/modifica_reperto')
                    }}
                    /> 
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
		</DataTable>
	</div>
</div>
