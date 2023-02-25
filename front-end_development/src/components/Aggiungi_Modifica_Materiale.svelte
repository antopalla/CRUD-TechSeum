<script>    
    const form = {
        nome: "",
        id:"",
    };

    import Header from "./Header.svelte";
    import { TextInput } from "carbon-components-svelte";
    import { Grid, Row, Column } from "carbon-components-svelte";
    import { Button } from "carbon-components-svelte";
	import SelectMaterialiModifica from "./Select_Materiali_Modifica.svelte";
    import { codmateriale } from "../js/materiale.js"
	import { creaMateriale, modificaMateriale } from "../js/functions";
    import {url_path} from "../js/const.js"
	let styleColumn = "font-size: 18px;float:left; padding: 0px ; padding-top: 10px"

    let comp;

    const modifica_dati= async () =>{
        await modificaMateriale(form.nome,$codmateriale)
        comp.update()
    }

    const handleForm = async () => {
        await creaMateriale(form.nome)
        form.nome=""
        comp.update()
    };

    const elimina_materiale = async () => {
        var xmlHttp = new XMLHttpRequest();
	    xmlHttp.open('GET', 'http://' + url_path + '/back-end_development/materiale/delete_materiale.php?codmateriale='+$codmateriale , false);
		xmlHttp.send( null );
        form.nome=""
        form.Adf=""
        form.Adn=""
        comp.update()
    }

    const carica_dati = async ()=> {
        const url = 'http://' + url_path + '/back-end_development/materiale/get_materiale.php?codmateriale='+$codmateriale;
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON
        let materiale=res.data;

        form.nome=materiale[0].nomemateriale
        form.id=$codmateriale
        document.getElementById("bottone").innerHTML='<Button id="bottone" on:click={carica_dati} type="submit" size="lg" style="float:right;margin-right:7%;margin-top:2%" kind="ghost" name="add">MODIFICA</Button>'
    }
</script>

<Header />
<form id="myform" on:submit|preventDefault={handleForm}>
    <div>
        <Grid>
            <Row>
                <Column style={styleColumn}> Se devi modificare un materiale selezionalo da qui: </Column>
                <Column style={styleColumn}>
                    <SelectMaterialiModifica bind:this={comp}/>
                </Column>
                
            </Row>
            <Row>
                <Column style={styleColumn}>Premi questo bottone per modificare l'autore selezionato nella select: </Column>
                
            </Row>
            <Row>
                <Column style={styleColumn}> Nome Materiale: </Column>
                <Column style={styleColumn}>
                    <TextInput bind:value={form.nome} placeholder="Inserisci nome materiale..." name='nome_mat' id='nome_mat'/>
                </Column>
            </Row>
        </Grid>
    </div>
    <div>
        <Button on:click={modifica_dati} size="lg" style="float:right;margin-right:7%;margin-top:2%" kind="ghost">MODIFICA</Button>
        <Button on:click={carica_dati} id="bottone" type="submit" size="lg" style="float:right;margin-right:7%;margin-top:2%" kind="ghost" name="add">AGGIUNGI</Button>
        <Button on:click = {elimina_materiale} size="lg" style="float:right;margin-right:7%;margin-top:2%" kind="ghost">ELIMINA</Button>
        
    </div>
</form>


