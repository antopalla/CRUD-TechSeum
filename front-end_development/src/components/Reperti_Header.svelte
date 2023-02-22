<script>
	import { current_User, loggedIn } from "../js/data-sessione.js";
	import { goto } from "$app/navigation";
    import { 
		Toggle,
		Button,
		Theme,
		ImageLoader,
		InlineLoading,
		SideNav,
		SideNavItems,
	} from "carbon-components-svelte";
	
	import "carbon-components-svelte/css/all.css";
	import Add from "carbon-icons-svelte/lib/Add.svelte";
	import Close from "./icone/Close.svelte";
	import Person from "carbon-icons-svelte/lib/Person.svelte";	
	import Menu from "./icone/Menu.svelte";
	//import delle icone

	let theme = "white"; // "white" | "g10" | "g80" | "g90" | "g100"
	let dark_mode_toggled = false;
	let sideNavStyle = "position: absolute ;top: 0px; width: 10%; border-right: 1px solid #161616; transition: transform 300ms ease-in;"
	let buttonStyle="align-items: center; padding: 10px; color:#161616 ;"
	let toggleStyle= "padding-left:10px ; justify-content: center; padding-bottom: 12px;"
	let bgColor = "#e0e0e0"
	let text_color = "#161616"
	let title_shadow_color = "#00000055";
	let menu_icon = Menu

	function redirectUtenti() {
        if ($current_User["amministratore"] == 1 && $loggedIn == true) {
			goto("/utenti")
        }
		else {
			alert("Non hai i permessi per accedere a questa pagina! Contattare un amministratore.")
		}
    }

	function redirectAggReperto() {
		goto("/reperti/aggiungi_reperto")
	}

	let isSideNavOpen = false

	const darkModeHandler = () =>{
		dark_mode_toggled = !dark_mode_toggled
		if(dark_mode_toggled){
			theme = "g100"
			buttonStyle = "align-items: center; padding: 10px; color:#c6c6c6 ;"
			bgColor = "#393939"
			text_color = "#c6c6c6"
			title_shadow_color = "#ffffff55"
		}
		else{
			theme = "white"
			buttonStyle = "align-items: center; padding: 10px; color:#161616 ;"
			bgColor = "#e0e0e0"
			text_color = "#161616"
			title_shadow_color = "#00000055"
		}		
	}

</script>

<Theme bind:theme /> <!-- permette al sito di cambiare tema in tempo reale -->

<style>
	@import url('https://fonts.googleapis.com/css2?family=Phudu:wght@900&display=swap');
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
		position: absolute;
		left: 10%;
		padding: 0px;
		width: 100px;
		height: 100px;
	}
	.menu_title{
		font-family: 'Phudu', cursive;
		height: 84px;
	}
	.header_title{
		height: 100px;
		display: flex;
		align-items: center;
		font-family: 'Phudu', cursive;
		font-size: 4em ;	
	}
</style>

<SideNav 
	bind:isOpen={isSideNavOpen}
	style={sideNavStyle + "background-color: "+ bgColor}
	>
  <SideNavItems>
	<center><h1 class="menu_title" style="color: {text_color};">MENU</h1></center> 
	<Toggle
			style =  {toggleStyle}			
			size="sm"
			bind:dark_mode_toggled 
			labelA = "White mode"
			labelB = "Dark mode"
			on:toggle = {darkModeHandler}	
		/>
	<Button icon = {Add} kind = "ghost" style={buttonStyle} on:click={redirectAggReperto}> Aggiungi reperti </Button>
    <Button icon = {Person} kind = "ghost" style={buttonStyle + "width : 100%"} on:click={redirectUtenti}> Utenti </Button>
  </SideNavItems>	
</SideNav>


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
		<h1 class="header_title" style="text-shadow: 2px 2px {title_shadow_color};" >TechSeum</h1>	
		<Button 
			icon = {menu_icon}
			iconDescription = "Menu"
			kind = "ghost"
			style = {buttonStyle +" position: absolute ; right: 10% ; height : 100px ; margin: 0px"}
			on:click = {()=>{
				isSideNavOpen = !isSideNavOpen;
				if(!isSideNavOpen){menu_icon = Menu;}
				else{menu_icon = Close}
			}}		
		/>
		<!--
		<Button kind="ghost" icon = {Person} size="small" style={buttonStyle} on:click={handleButton}>Utenti</Button>
		<Button kind="ghost" icon = {Add} size="small" style={buttonStyle} on:click={redirectToAggiungiReperto}>Aggiungi reperto</Button> 
		-->
	</div>
</div>





