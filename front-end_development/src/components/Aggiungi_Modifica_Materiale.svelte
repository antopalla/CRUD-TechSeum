<script>
    // Passa i dati all'api crea_utente
    
    const form = {
        nome: "",
        Adn: "",
        Adf: "",
        id:"",
    };
    import Header from "./Header.svelte";
    import { TextInput } from "carbon-components-svelte";
    import { Grid, Row, Column } from "carbon-components-svelte";
    import { Button } from "carbon-components-svelte";
	import SelectMateriali from "./Select_Materiali.svelte";
    import { codmateriale } from "../js/materiale.js"
    import { materiale } from "../js/data_materiali.js"
	import { creaMateriale, modificaMateriale,eliminaMateriale } from "../js/functions";
    import {url_path} from "../js/const.js"
	let styleColumn = "font-size: 18px;float:left; padding: 0px ; padding-top: 10px"

    let selectedRowIds = []; //contiene id dell'elemento selezionato
	$: console.log("selectedRowIds", selectedRowIds);

    const modifica_dati= async () =>{
        await modificaMateriale(form.nome,$codmateriale)
    }

    const handleForm = async () => {
        await creaMateriale(form.nome)
        from.nome=''   
    };

    const carica_dati = async ()=> {
        const url = 'http://' + url_path + '/back-end_development/materiale/get_materiale.php?codmateriale='+$codmateriale;
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON
        $materiale=res.data;
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
                    <SelectMateriali/>
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
        <Button on:click = {()=>
            {
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.open('GET', 'http://' + url_path + '/back-end_development/materiale/delete_materiale.php?codmateriale='+selectedRowIds , false ); // false per richieste sincrone
                //cancella reperto selezionato in base all id 
                xmlHttp.send( null );
                $materiale = $materiale.filter((row) => !selectedRowIds.includes(row.id));
                //rimuove il reperto dalla tabella grafica 	
                selectedRowIds = [];
            }	
        }	size="lg" style="float:right;margin-right:7%;margin-top:2%" kind="ghost">ELIMINA</Button>
        
    </div>
</form>


