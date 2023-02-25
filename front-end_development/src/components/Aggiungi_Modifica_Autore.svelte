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
	import SelectAutori from "./Select_Autore_Modifica.svelte";
    import { codautore } from "../js/autore.js"
	import { creaAutore, modificaAutore } from "../js/functions";
    import {url_path} from "../js/const.js"
	let styleColumn = "font-size: 18px;float:left; padding: 0px ; padding-top: 10px"

    function handleMousemove(e) {
		e.target.placeholder=""
	}

    function normale(e){
        if(e.target.name=="Nom_Autore")
        {
            e.target.placeholder="Inserire nome autore: "
        }
        if(e.target.name=="Adn")
        {
            e.target.placeholder="Anno di nascita: "
        }
        if(e.target.name=="Adf")
        {
            e.target.placeholder="Anno di fine: "
        }
    } 

    const handleForm = async () => {
        //if(e.target.name=="add")
        //{
            await creaAutore(form.nome, form.Adn, form.Adf)
        //}
        //else
        //{
            //await modificaAutore(form.nome,form.Adn,form,Adf,form.id)
            //alert("ciao")
            
        //}
        
    };

    const carica_dati = async ()=> {
        const url = 'http://' + url_path + '/back-end_development/autore/get_autore.php?codautore='+$codautore;
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON
        let autore=res.data;
        form.nome=autore[0].nomeautore
        form.Adn=autore[0].annonascita
        form.Adf=autore[0].annofine
        form.id=$codautore
        document.getElementById("bottone").innerHTML='<Button id="bottone" on:click={carica_dati} type="submit" size="lg" style="float:right;margin-right:7%;margin-top:2%" kind="ghost" name="add">MODIFICA</Button>'
    }
</script>

<Header />
<form id="myform" on:submit|preventDefault={handleForm}>
    <div>
        <Grid>
            <Row>
                <Column style={styleColumn}> Se devi modificare un autore selezionalo da qui: </Column>
                <Column style={styleColumn}>
                    <SelectAutori/>
                </Column>
                
            </Row>
            <Row>
                <Column style={styleColumn}>Premi questo bottone per modificare l'autore selezionato nella select: </Column>
                <Column style={styleColumn}>
                    <Button on:click={carica_dati} size="lg" style="float:right;margin-right:7%;margin-top:2%" kind="ghost">MODIFICA</Button>
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
        <Button id="bottone" type="submit" size="lg" style="float:right;margin-right:7%;margin-top:2%" kind="ghost" name="add">AGGIUNGI</Button>
        
    </div>
</form>


