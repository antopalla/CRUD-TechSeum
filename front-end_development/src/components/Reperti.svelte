<script>
    import {reperti} from '../js/data-reperti.js'
	import { url_path } from "../js/const.js"
    import {onMount} from 'svelte'

    import {
		DataTable, 
		Toolbar, 
		ToolbarContent, 
		ToolbarSearch,
		ToolbarBatchActions,
		Button
	} from "carbon-components-svelte"

    import Header from './Reperti_Header.svelte'
	import TrashCan from "carbon-icons-svelte/lib/TrashCan.svelte";
	import ChartCustom from "carbon-icons-svelte/lib/ChartCustom.svelte";
	import Menu from './icone/Menu.svelte';
	import Add from "carbon-icons-svelte/lib/Add.svelte";

    onMount(async() => {
        const url = 'http://' + url_path + '/back-end_development/reperto/get_reperti.php'
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON

        $reperti = res.data // Contiene l'array contenuto nell'oggetto; il simbolo $ indica come la variabile sia presa dall'import 
                            // del JavaScript, Variabile Front-End globale per i reperti
	
		const formattaData = (data) => {
			data = data.split(" ")
			data = data[0].split("-")
			return data[2]+" "+data[1]+" "+data[0] //riordina data giorno mese anno 
		}

		$reperti.forEach((item) => {
			item.datacatalogazione = formattaData(item.datacatalogazione)
		})// formatta data per ogni reperto
        
    })

    let filteredRowIds = []; //contiene gli degli elementi cercati
    $: console.log("filteredRowIds", filteredRowIds);

	 let selectedRowIds = []; //contiene id dell'elemento selezionato
	$: console.log("selectedRowIds", selectedRowIds);

	const redirectAggReperto = () => {
		goto("/aggiungi_reperto")
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
			style="padding-top : 0 ;"
			bind:selectedRowIds 
			radio
			size="medium"
			headers={[
				{ key: "nome", value: "Nome", width : "20%",minWidth: "100px"},
				{ key: "definizione", value: "Definizione" ,width : "25%", minWidth:"200px"},
				{ key: "nomeautore", value: "Autore",width: "15%" , minWidth:"200px"},
				{ key: "scopo", value: "Scopo" ,width: "25%" ,minWidth:"200px"},
				{ key: "datacatalogazione", value: "Data Catalogazione",width : "10%", minWidth:"200px"},
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
							on:click = {()=>
								{
									var xmlHttp = new XMLHttpRequest();
									xmlHttp.open('GET', 'http://' + url_path + '/back-end_development/reperto/delete_reperto.php?codassoluto='+selectedRowIds , false ); // false per richieste sincrone
									//cancella reperto selezionato in base all id 
									xmlHttp.send( null );
									$reperti = $reperti.filter((row) => !selectedRowIds.includes(row.id));
									//rimuove il reperto dalla tabella grafica 	
									selectedRowIds = [];
								}	
							}		
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
		</DataTable>
	</div>
</div>
