<script>
    import {reperti} from '../js/data-reperti.js'
    import {onMount} from 'svelte'
    import {DataTable, 
	Toolbar, 
	ToolbarContent, 
	ToolbarSearch,
	ToolbarMenu,
    ToolbarMenuItem,
    ToolbarBatchActions, 
	Button} from "carbon-components-svelte"
    import Header from './Reperti_Header.svelte'
	import {missing_component} from 'svelte/internal';

    onMount(async() => {
        const url = 'http://localhost/back-end_development/reperto/get_reperti.php'
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON

        $reperti = res.data // Contiene l'array contenuto nell'oggetto; il simbolo $ indica come la variabile sia presa dall'import 
                            // del JavaScript, Variabile Front-End globale per i reperti
	
		const formattaData = (data) => {
			data = data.split(" ")
			data = data[0].split("-")
			return data[2]+" "+data[1]+" "+data[0]
		}

		$reperti.forEach((item) => {
			item.datacatalogazione = formattaData(item.datacatalogazione)
		})
        //console.log($reperti)
    })

    let filteredRowIds = [];
    $: console.log("filteredRowIds", filteredRowIds);

	 let selectedRowIds = [];

	$: console.log("selectedRowIds", selectedRowIds);
</script>

<Header />

<style>
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
		<DataTable bind:selectedRowIds 
			radio
			title="Gestione Reperti"
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
			<Toolbar>
				<ToolbarContent>
					<ToolbarSearch
						shouldFilterRows
					/>	
					<ToolbarBatchActions>
						<Button
							on:click = {()=>
								{
									var xmlHttp = new XMLHttpRequest();
									xmlHttp.open( "GET", "http://localhost/back-end_development/reperto/delete_reperto.php?codassoluto="+selectedRowIds , false ); // false for synchronous request
									xmlHttp.send( null );
									//response = xmlHttp.responseText;
									$reperti = $reperti.filter((row) => !selectedRowIds.includes(row.id));
									selectedRowIds = [];
								}	
							}		
						>Rimuovi</Button>
					</ToolbarBatchActions>	
				</ToolbarContent>
			</Toolbar>
		</DataTable>
	</div>
</div>

