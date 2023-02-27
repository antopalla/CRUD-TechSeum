<script>
	import { current_User, loggedIn } from "../js/data-sessione.js";
	import { goto } from "$app/navigation";
    import {Toggle, Button, Theme, ImageLoader, InlineLoading, SideNav, SideNavItems} from "carbon-components-svelte";
	import "carbon-components-svelte/css/all.css";
	import Close from "./icone/Close.svelte";
	import Menu from "./icone/Menu.svelte";
	import Archive from "carbon-icons-svelte/lib/Archive.svelte";
	import Person from "carbon-icons-svelte/lib/Person.svelte";	
	import Logout from "carbon-icons-svelte/lib/Logout.svelte";

	let theme = "white"; // "white" | "g10" | "g80" | "g90" | "g100"
	let dark_mode_toggled = false;
	let sideNavStyle = "position: absolute ;top: 50px; width: 10%; border-right: 1px solid #161616; transition: transform 300ms ease-in;"
	let buttonStyle="align-items: center; padding: 10px; color:#161616 ;"
	let toggleStyle= "padding-left:10px ; justify-content: center; padding-bottom: 12px;"
	let bgColor = "#f1c40e"
	let menuBgColor = "#e0e0e0"
	let text_color = "#161616"
	let menu_icon = Menu

	function redirectUtenti() {
        if ($current_User["amministratore"] == 1 && $loggedIn == true) {
			goto("/utenti")
        }
		else {
			alert("Non hai i permessi per accedere a questa pagina! Contattare un amministratore.")
		}
    }

	function redirectReperti() {
        goto("/reperti")
    }

	function logout() {
		$loggedIn = false
		$current_User = null
		goto("/")
	}

	

	let isSideNavOpen = false

	const darkModeHandler = () =>{
		dark_mode_toggled = !dark_mode_toggled
		if(dark_mode_toggled){
			theme = "g100"
			buttonStyle = "align-items: center; padding: 10px; color:#c6c6c6 ;"
			bgColor = "#393939"
			text_color = "#c6c6c6"
			menuBgColor = "#393939"
		}
		else{
			theme = "white"
			buttonStyle = "align-items: center; padding: 10px; color:#161616 ;"
			bgColor = "#f1c40e"
			menuBgColor = "#e0e0e0"
			text_color = "#161616"
		}		
	}

</script>

<Theme bind:theme /> <!-- permette al sito di cambiare tema in tempo reale -->

<style>
	@import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&display=swap');
	.container{
		justify-content: center;
		display: flex;
	}
	.header{
		justify-content: center;
		display: flex;
		width: 100%;
	}
	.logo{
		position: absolute;
		right: 0%;
		padding: 0px;
		width: 50px;
		height: 50px;
	}
	.header_title{
		height: 50px;
		display: flex;
		align-items: center;
		font-family: 'Josefin Sans', sans-serif ;
		font-size: 2em ;	
	}
</style>

<SideNav 
	bind:isOpen={isSideNavOpen}
	style={sideNavStyle + "background-color: "+ menuBgColor}
	>
  <SideNavItems>
	<Toggle
			style =  {toggleStyle}			
			size="sm"
			bind:dark_mode_toggled 
			labelA = "White mode"
			labelB = "Dark mode"
			on:toggle = {darkModeHandler}	
		/>
	
	<Button icon = {Archive} kind = "ghost" style={buttonStyle + "width : 100%"} on:click={redirectReperti}> Reperti </Button>
    <Button icon = {Person} kind = "ghost" style={buttonStyle + "width : 100%"} on:click={redirectUtenti}> Utenti </Button>
	<Button icon = {Logout} kind = "ghost" style={buttonStyle + "width : 100%"} on:click={logout}> Logout </Button>
  </SideNavItems>	
</SideNav>


<div id="reperti_header" class="container">
	<div class="header" style="background-color: {bgColor};">
		<div class="logo">
			<a href="https://techseum.itdimaggio.edu.it"><ImageLoader src="/logo.png" >
				<svelte:fragment slot="loading">
					<InlineLoading />
				</svelte:fragment>
				<svelte:fragment slot="error">An error occurred.</svelte:fragment>
			</ImageLoader></a>
		</div>
		<h1 class="header_title" >DI MAGGIO •TECHSEUM</h1>	
		<Button 
			icon = {menu_icon}
			iconDescription = "Menu"
			kind = "ghost"
			style = {buttonStyle +" position: absolute ; left: 0% ; height : 50px ; margin: 0px"}
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





