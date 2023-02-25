<script>    
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
	import SelectAutoriModifica from "./Select_Autore_Modifica.svelte";
    import { codautore } from "../js/autore.js"
	import { creaAutore, modificaAutore } from "../js/functions";
    import {url_path} from "../js/const.js"
	let styleColumn = "font-size: 18px;float:left; padding: 0px ; padding-top: 10px"

    let comp;

    const handleForm = async () => {
        await creaAutore(form.nome, form.Adn, form.Adf)
        form.nome=""
        form.Adf=""
        form.Adn=""
        comp.update()
    } 

    const modifica_autore = async () => {
        await modificaAutore(form.nome,form.Adn,form.Adf,$codautore)
        form.nome=""
        form.Adf=""
        form.Adn=""
        comp.update()
    }

    const elimina_autore = async () => {
        var xmlHttp = new XMLHttpRequest();
	    xmlHttp.open('GET', 'http://' + url_path + '/back-end_development/autore/delete_autore.php?codautore='+$codautore , false);
		xmlHttp.send( null );
        form.nome=""
        form.Adf=""
        form.Adn=""
        comp.update()
    }

    const carica_dati = async ()=> {
        const url = 'http://' + url_path + '/back-end_development/autore/get_autore.php?codautore='+$codautore;
        let res = await fetch(url)
        res = await res.json() 
        let autore=res.data;
        
        form.nome=autore[0].nomeautore
        form.Adn=autore[0].annonascita
        form.Adf=autore[0].annofine
        form.id=$codautore
        document.getElementById("bottone_add").innerHTML='<Button id="bottone_add" style="display:none;" on:click={carica_dati} type="submit" size="lg" kind="ghost" name="add">AGGIUNGI</Button>'
        document.getElementById("bottone_del").innerHTML='<Button id="bottone_add" style="display:none;" on:click={carica_dati} type="submit" size="lg" kind="ghost" name="add">AGGIUNGI</Button>'
    }

</script>

<Header />
<form id="myform" on:submit|preventDefault={handleForm}>
    <div>
        <Grid>
            <Row>
                <Column style={styleColumn}> Se devi modificare un autore selezionalo da qui: </Column>
                <Column style={styleColumn}>
                    <SelectAutoriModifica bind:this={comp}/>
                </Column>
                
            </Row>
            <Row>
                <Column style={styleColumn}>Premi questo bottone per modificare l'autore selezionato nella select: </Column>
                <Column style={styleColumn}>
                    <Button on:click={carica_dati} size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary">MODIFICA</Button>
                </Column>
                
            </Row>
            <Row>
                <Column style={styleColumn}> Nome Autore: </Column>
                <Column style={styleColumn}>
                    <TextInput bind:value={form.nome} placeholder="Inserisci nome autore..." name='nome_aut' id='nome_aut'/>
                </Column>
            </Row>
            <Row>
                <Column style={styleColumn}>Anno di nascita: </Column>
                <Column style={styleColumn}>
                    <TextInput bind:value={form.Adn} placeholder="Inserire anno di nascita..." name='Adn' id='Adn'/>
                </Column>
            </Row>
            <Row>
                <Column style={styleColumn}>Anno di fine: </Column>
                <Column style={styleColumn}>
                    <TextInput bind:value={form.Adf} placeholder="Inserisci anno di fine..." name='Adf' id='Adf'/>
                </Column>
            </Row>
        </Grid>
    </div>
    <div>
        <Button id="bottone_add" type="submit" size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary" name="add">AGGIUNGI</Button>
        
    </div>
</form>
<div>
    <Button id="bottone_mod" on:click={modifica_autore} type="submit" size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary" name="add">MODIFICA</Button>
</div>
<div>
    <Button id="bottone_del" on:click={elimina_autore} type="submit" size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary" name="add">ELIMINA</Button>
</div>
