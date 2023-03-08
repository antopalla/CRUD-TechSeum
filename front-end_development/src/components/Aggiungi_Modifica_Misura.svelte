<script>    
    // IMPORT FROM CARBON
    import { TextInput } from "carbon-components-svelte";
    import { Grid, Row, Column } from "carbon-components-svelte";
    import { Button } from "carbon-components-svelte";

    // IMPORT FUNZIONI E VARIABILI
    import { creaMisura, modificaMisura } from "../js/functions";
    import { tipomisura } from "../js/misura.js"
    import { url_path } from "../js/const.js"

    // IMPORT COMPONENTS
    import Header from "./Header.svelte";
	import SelectTipomisuraModifica from "./Select_Tipomisura_Modifica.svelte";

    // Variabili del form
    const form = {
        id: "",
        nomemisura: "",
        unitadimisura: ""
    };

    // Variabile per il binding per utilizzare la funzione da un component esterno
    let comp;

     // Variabile per disattivare i bottoni
     let invalid;

    // Stile righe e colonne per avere i components ordinati
    let styleColumn = "font-size: 18px;float:left; padding: 0px ; padding-top: 10px"

    // Invio variabili del form alla funzione che comunica con l'API per la creazione di un nomimisure
    const handleForm = async () => {
        await creaMisura(form.id, form.nomemisura, form.unitadimisura)

        form.id = ""
        form.nomemisura = ""
        form.unitadimisura = ""

        comp.update()
    };

    // Invio variabili del form alla funzione che comunica con l'API per la modifica di un materiale
    const modifica_misura= async () =>{
        await modificaMisura($tipomisura, form.nomemisura, form.unitadimisura)
        
        form.id = ""
        form.nomemisura = ""
        form.unitadimisura = ""

        comp.update()
        invalid = false;
    }

    // Funzione per l'eliminazione di una misura
    const elimina_misura = async () => {
        var xmlHttp = new XMLHttpRequest();
	    xmlHttp.open('GET', url_path + '/back-end_development/misura/delete_misura.php?tipomisura='+$tipomisura , false);
		xmlHttp.send( null );

        form.id = ""
        form.nomemisura = ""
        form.unitadimisura = ""

        comp.update()
    }

    let lenN=0,lenU=0,lenT=0;
    // Funzione per il fetch dei dati dall'API get_misura
    const carica_dati = async ()=> {
        const url = url_path + '/back-end_development/misura/get_misura.php?tipomisura='+$tipomisura;
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON
        let misura=res.data;

        form.nomemisura = misura[0].nomemisura
        form.unitadimisura = misura[0].unitadimisura
        form.id=$tipomisura

        lenN=form.nomemisura.length;
        lenU=form.unitadimisura.length;
        lenT=form.tipomisura.length;

        invalid = true
    }
</script>


<!--  Header -->
<Header />

<!--  Inizio form -->
<form on:submit|preventDefault={handleForm}>
    <div>
        <Grid>

            <!--  Select misura -->
            <Row>
                <Column style={styleColumn}> Se devi modificare una misura selezionala da qui: </Column>
                <Column style={styleColumn}>
                    <SelectTipomisuraModifica bind:this={comp}/>
                </Column>
            </Row>

             <!--  Bottone per fare il fetch dei dati della misura selezionato nella select -->
             <Row>
                <Column style={styleColumn}>Premi questo bottone per modificare la misura selezionata nella select: </Column>
                <Column style={styleColumn}>
                    <Button on:click={carica_dati} size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary">CARICA MISURA</Button>
                </Column>
            </Row>

            <!--  Tipo misura -->
            <Row>
                <Column style={styleColumn}> Tipo misura: </Column>
                <Column style={styleColumn}>
                    <TextInput bind:value={form.id} placeholder="Inserisci tipo misura..." maxlength='1' oninput="document.getElementById('lenTipo').innerHTML = this.value.length" />
                    <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/1</div>
                    <div id="lenTipo" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenT}</div>
                </Column>
            </Row>

            <!--  Nome misura -->
            <Row>
                <Column style={styleColumn}> Nome misura: </Column>
                <Column style={styleColumn}>
                    <TextInput bind:value={form.nomemisura} placeholder="Inserisci nome misura..." 
                      maxlength='50' oninput="document.getElementById('lenNome').innerHTML = this.value.length" />
                    <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/50</div>
                    <div id="lenNome" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenN}</div>
                </Column>
            </Row>

            <!--  Unità di misura -->
            <Row>
                <Column style={styleColumn}> Unità di misura: </Column>
                <Column style={styleColumn}>
                    <TextInput bind:value={form.unitadimisura} placeholder="Inserisci unità di misura..." maxlength='10' oninput="document.getElementById('lenUnita').innerHTML = this.value.length" />
                    <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/10</div>
                    <div id="lenUnita" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenU}</div>
                </Column>
            </Row>
        </Grid>

    <!--  Bottone per il submit dei dati; creazione della misura -->
    <div>
        <Button id="bottone_add" disabled={invalid} type="submit" size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary">AGGIUNGI</Button>
    </div>
</form>

<!--  Bottone per il submit dei dati; modifica della misura -->
<div>
<Button id="bottone_mod" on:click={modifica_misura} type="submit" size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary">MODIFICA</Button>
</div>

<!--  Bottone per il submit dei dati; eliminazione della misura -->
<div>
<Button id="bottone_del" on:click={elimina_misura} disabled={invalid} type="submit" size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary">ELIMINA</Button>
</div>

