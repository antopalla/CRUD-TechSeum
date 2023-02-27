<script>
    import {Toggle, Theme, ImageLoader, InlineLoading} from "carbon-components-svelte";
	import "carbon-components-svelte/css/all.css";
	let theme = "white"; // "white" | "g10" | "g80" | "g90" | "g100"
	let dark_mode_toggled = false;
	let buttonStyle="align-items: center; padding: 10px; color:#161616 ;"
	let bgColor = "#f1c40e"
	let menuBgColor = "#e0e0e0"
	let text_color = "#161616"

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
		width: 80%;
		background-color: #f1c40e;
	}
	.logo{
		position: absolute;
		right: 10%;
		padding: 0px;
		width: 50px;
		height: 50px;
	}
	.header_title{
		height: 50px;
		display: flex;
		align-items: center;
		font-family: 'Josefin Sans', sans-serif ;
		font-size: 1.5em ;	
	}
	
</style>
<div id="reperti_header" class="container">
	<div class="header">
		<div class="logo">
			<ImageLoader src="/logo.png">
				<svelte:fragment slot="loading">
					<InlineLoading />
				</svelte:fragment>
				<svelte:fragment slot="error">An error occurred.</svelte:fragment>
			</ImageLoader>
		</div>
		<div>
			<Toggle
				style = {" position: absolute ; left: 10% ; height : 50px ; margin: 5px"}			
				size="sm"
				bind:dark_mode_toggled 
				labelA = "White mode"
				labelB = "Dark mode"
				on:toggle = {darkModeHandler}	
			/>
			</div>
		<h1 class="header_title" >DI MAGGIO • TECHSEUM</h1>	
		<!--
		<Button kind="ghost" icon = {Person} size="small" style={buttonStyle} on:click={handleButton}>Utenti</Button>
		<Button kind="ghost" icon = {Add} size="small" style={buttonStyle} on:click={redirectToAggiungiReperto}>Aggiungi reperto</Button> 
		-->
	</div>
</div>