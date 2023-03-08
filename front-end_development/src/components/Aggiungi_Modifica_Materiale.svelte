<script>    
    // IMPORT FROM CARBON
    import { TextInput } from "carbon-components-svelte";
    import { Grid, Row, Column } from "carbon-components-svelte";
    import { Button } from "carbon-components-svelte";

    // IMPORT FUNZIONI E VARIABILI
    import { creaMateriale, modificaMateriale } from "../js/functions";
    import { codmateriale } from "../js/materiale.js"
    import { url_path } from "../js/const.js"

    // IMPORT COMPONENTS
    import Header from "./Header.svelte";
	import SelectMaterialiModifica from "./Select_Materiali_Modifica.svelte";

    // Variabili del form
    const form = {
        nome: "",
        id:"",
    };
    
    // Variabile per il binding per utilizzare la funzione da un component esterno
    let comp;

     // Variabile per disattivare i bottoni
     let invalid;

    // Stile righe e colonne per avere i components ordinati
    let styleColumn = "font-size: 18px;float:left; padding: 0px ; padding-top: 10px"

    // Invio variabili del form alla funzione che comunica con l'API per la creazione di un materiale
    const handleForm = async () => {
        await creaMateriale(form.nome)

        form.nome=""

        comp.update()
    };

    // Invio variabili del form alla funzione che comunica con l'API per la modifica di un materiale
    const modifica_materiale= async () =>{
        await modificaMateriale(form.nome,$codmateriale)

        form.nome=""

        comp.update()
        invalid = false;
    }

    // Funzione per l'eliminazione di un materiale
    const elimina_materiale = async () => {
        var xmlHttp = new XMLHttpRequest();
	    xmlHttp.open('GET', url_path + '/back-end_development/materiale/delete_materiale.php?codmateriale='+$codmateriale , false);
		xmlHttp.send( null );

        form.nome=""

        comp.update()
    }

    let lenN=0;
    // Funzione per il fetch dei dati dall'API get_materiale
    const carica_dati = async ()=> {
        const url = url_path + '/back-end_development/materiale/get_materiale.php?codmateriale='+$codmateriale;
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON
        let materiale=res.data;

        form.nome=materiale[0].nomemateriale
        form.id=$codmateriale

        lenN=form.nome.length;
        
        invalid = true
    }
</script>


<!--  Header -->
<Header />

<!--  Inizio form -->
<form on:submit|preventDefault={handleForm}>
    <div>
        <Grid>

            <!--  Select materiali -->
            <Row>
                <Column style={styleColumn}> Se devi modificare un materiale selezionalo da qui: </Column>
                <Column style={styleColumn}>
                    <SelectMaterialiModifica bind:this={comp}/>
                </Column>
            </Row>

             <!--  Bottone per fare il fetch dei dati del materiale selezionato nella select -->
             <Row>
                <Column style={styleColumn}>Premi questo bottone per modificare il materiale selezionato nella select: </Column>
                <Column style={styleColumn}>
                    <Button on:click={carica_dati} size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary">CARICA MATERIALE</Button>
                </Column>
            </Row>

            <!--  Nome materiali -->
            <Row>
                <Column style={styleColumn}> Nome Materiale: </Column>
                <Column style={styleColumn}>
                    <TextInput bind:value={form.nome} placeholder="Inserisci nome materiale..." name='nome_mat' id='nome_mat'
                    maxlength='32' oninput="document.getElementById('lenNome').innerHTML = this.value.length" />
                    <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/32</div>
                    <div id="lenNome" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenN}</div>
                </Column>
            </Row>
        </Grid>

    <!--  Bottone per il submit dei dati; creazione del materiale -->
    <div>
        <Button id="bottone_add" disabled={invalid} type="submit" size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary">AGGIUNGI</Button>
    </div>
</form>

<!--  Bottone per il submit dei dati; modifica del materiale-->
<div>
<Button id="bottone_mod" on:click={modifica_materiale} type="submit" size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary">MODIFICA</Button>
</div>

<!--  Bottone per il submit dei dati; eliminazione del materilae -->
<div>
<Button id="bottone_del" on:click={elimina_materiale} disabled={invalid} type="submit" size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary">ELIMINA</Button>
</div>

