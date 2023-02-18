<script>
	import { current_User, loggedIn } from "../js/data-sessione.js";
	import { goto } from "$app/navigation";
    import { 
		Toggle,
		Button,
		Theme,
		ImageLoader,
		InlineLoading
	} from "carbon-components-svelte";
	
	import "carbon-components-svelte/css/all.css";
	import Add from "carbon-icons-svelte/lib/Add.svelte";
	import Person from "carbon-icons-svelte/lib/Person.svelte";
	
	//import delle icone

	let theme = "white"; // "white" | "g10" | "g80" | "g90" | "g100"
	let dark_mode_toggled = false;
	let buttonStyle="width:10%; align-items: center; padding: 10px; color:#161616 ; border : 1px solid #161616;"
	let toggleStyle= "padding-left:10px ; justify-content: center; padding-bottom: 12px;"
	let bgColor = "#e0e0e0"

	function handleButton() {
        if ($current_User["amministratore"] == 1 && $loggedIn == true) {
			goto("/utenti")
        }
		else {
			alert("Non hai i permessi per accedere a questa pagina! Contattare un amministratore.")
		}
    }

	function redirectToAggiungiReperto() {
		goto("/reperti/aggiungi_reperto")
	}


</script>

<Theme bind:theme /> <!-- permette al sito di cambiare tema in tempo reale -->

<style>
	.container{
		justify-content: center;
		display: flex;
	}
	.header{
		justify-content: center;
		display: flex;
		width: 80%;
	}
	.logo{
		padding: 0px;
		width: 100px;
		height: 100px;
	}
</style>


<div id="reperti_header" class="container">
	

	<div class="header" style="background-color: {bgColor};">
		<div class="logo">
			<ImageLoader src="/logo.png">
				<svelte:fragment slot="loading">
					<InlineLoading />
				</svelte:fragment>
				<svelte:fragment slot="error">An error occurred.</svelte:fragment>
			</ImageLoader>
		</div>
		<Toggle
			style =  {toggleStyle}			
			size="sm"
			bind:dark_mode_toggled 
			labelA = "White mode"
			labelB = "Dark mode"
			on:toggle = {() => {
				dark_mode_toggled = !dark_mode_toggled
				if(dark_mode_toggled){
					theme = "g100"
					buttonStyle = "width:10%; align-items: center; padding: 10px; color:#c6c6c6 ; border : 1px solid #c6c6c6; "
					bgColor = "#393939"
				}
				else{
					theme = "white"
					buttonStyle="width:10%; align-items: center; padding: 10px; color:#161616 ; border : 1px solid #161616; "
					bgColor = "#e0e0e0"
				}
				//gestione della dark_mode
			}}	
		/>
		<Button kind="ghost" icon = {Person} size="small" style={buttonStyle} on:click={handleButton}>Utenti</Button>
		<Button kind="ghost" icon = {Add} size="small" style={buttonStyle} on:click={redirectToAggiungiReperto}>Aggiungi reperto</Button> 
	</div>
</div>




