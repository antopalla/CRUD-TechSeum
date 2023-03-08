<script>    
    // IMPORT FROM CARBON
    import { TextInput } from "carbon-components-svelte";
    import { Grid, Row, Column } from "carbon-components-svelte";
    import { Button } from "carbon-components-svelte";

    // IMPORT FUNZIONI E VARIABILI
    import { creaAutore, modificaAutore } from "../js/functions";
    import { codautore } from "../js/autore.js"
    import { url_path } from "../js/const.js"

    // IMPORT COMPONENTS
    import Header from "./Header.svelte";
	import SelectAutoriModifica from "./Select_Autore_Modifica.svelte";

    // Variabili del form
    const form = {
        nomeautore: "",
        annodinascita: "",
        annodifine: "",
        id: "",
    };

    // Variabile per il binding per utilizzare la funzione da un component esterno
    let comp;

    // Variabile per disattivare i bottoni
    let invalid;

    // Stile righe e colonne per avere i components ordinati
	let styleColumn = "font-size: 18px;float:left; padding: 0px ; padding-top: 10px"

    // Invio variabili del form alla funzione che comunica con l'API per la creazione di un autore
    const handleForm = async () => {
        await creaAutore(form.nomeautore, form.annodinascita, form.annodifine)

        form.nomeautore=""
        form.annodifine=""
        form.annodinascita=""
        
        comp.update()
    } 

    // Invio variabili del form alla funzione che comunica con l'API per la modifica di un autore
    const modifica_autore = async () => {
        await modificaAutore(form.nomeautore,form.annodinascita,form.annodifine,$codautore)

        form.nomeautore=""
        form.annodifine=""
        form.annodinascita=""
        
        comp.update()
        invalid = false
    }

    // Funzione per l'eliminazione di un autore
    const elimina_autore = async () => {
        var xmlHttp = new XMLHttpRequest();
	    xmlHttp.open('GET', url_path + '/back-end_development/autore/delete_autore.php?codautore='+$codautore , false);
		xmlHttp.send( null );

        form.nomeautore=""
        form.annodifine=""
        form.annodinascita=""

        comp.update()
    }

    let lenN=0;
    // Funzione per il fetch dei dati dall'API get_autore
    const carica_dati = async ()=> {
        const url = url_path + '/back-end_development/autore/get_autore.php?codautore='+$codautore;
        let res = await fetch(url)
        res = await res.json() 
        let autore=res.data;
        
        form.nomeautore=autore[0].nomeautore
        form.annodinascita=autore[0].annonascita
        form.annodifine=autore[0].annofine
        form.id=$codautore

        lenN=form.nomeautore.length;

        invalid = true
    }

</script>


<!--  Header -->
<Header />

<!--  Inizio form -->
<form on:submit|preventDefault={handleForm}>
    <div>
        <Grid>

            <!--  Select autori -->
            <Row>
                <Column style={styleColumn}> Se devi modificare un autore selezionalo da qui: </Column>
                <Column style={styleColumn}>
                    <SelectAutoriModifica bind:this={comp}/>
                </Column>
            </Row>

            <!--  Bottone per fare il fetch dei dati dell'autore selezionato nella select -->
            <Row>
                <Column style={styleColumn}>Premi questo bottone per modificare l'autore selezionato nella select: </Column>
                <Column style={styleColumn}>
                    <Button on:click={carica_dati} size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary">CARICA AUTORE</Button>
                </Column>
            </Row>

            <!--  Nome autore -->
            <Row>
                <Column style={styleColumn}> Nome Autore: </Column>
                <Column style={styleColumn}>
                    <TextInput bind:value={form.nomeautore} placeholder="Inserisci nome autore..." name='nome_aut' id='nome_aut'
                            maxlength='250' oninput="document.getElementById('lenNome').innerHTML = this.value.length" />
                    <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/250</div>
                    <div id="lenNome" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenN}</div>
                </Column>
            </Row>

            <!--  Anno di nascita autore -->
            <Row>
                <Column style={styleColumn}>Anno di nascita: </Column>
                <Column style={styleColumn}>
                    <TextInput bind:value={form.annodinascita} placeholder="Inserire anno di nascita..." name='annodinascita' id='annodinascita'/>
                </Column>
            </Row>

            <!--  Anno di fine autore -->
            <Row>
                <Column style={styleColumn}>Anno di fine: </Column>
                <Column style={styleColumn}>
                    <TextInput bind:value={form.annodifine} placeholder="Inserisci anno di fine..." name='annodifine' id='annodifine'/>
                </Column>
            </Row>
        </Grid>
    </div>

    <!--  Bottone per il submit dei dati; creazione dell'autore -->
    <div>
        <Button id="bottone_add" disabled={invalid} type="submit" size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary">AGGIUNGI</Button>
    </div>
</form>

<!--  Bottone per il submit dei dati; modifica dell'autore-->
<div>
    <Button id="bottone_mod" on:click={modifica_autore} type="submit" size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary">MODIFICA</Button>
</div>

<!--  Bottone per il submit dei dati; eliminazione dell'autore -->
<div>
    <Button id="bottone_del" on:click={elimina_autore} disabled={invalid} type="submit" size="sm" style="float:right;margin-right:7%;margin-top:2%" kind="tertiary">ELIMINA</Button>
</div>
