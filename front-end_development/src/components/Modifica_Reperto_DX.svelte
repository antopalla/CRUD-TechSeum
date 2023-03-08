<script>
    // IMPORT FROM SVELTE
    import { writable } from "svelte/store";
    import { goto } from "$app/navigation";
    import { onMount } from 'svelte'

    // IMPORT FROM CARBON
    import { TextInput, Select, SelectItem, Grid, Row, Column, TextArea, Button} from "carbon-components-svelte";
    import Add from "carbon-icons-svelte/lib/Add.svelte";

      // IMPORT VARIABILI FORM
    import { form_modifica } from "../js/const.js";

    // FUNZIONI DI REDIRECT
    function redirectAutore() {
        goto('/reperti/autore')
    }
    function redirectMateriale() {
        goto('/reperti/materiale')
    }
    function redirectMisura() {
        goto('/reperti/misura')
    }

    // VARIABILI
    let lenN=form_modifica.nome.length;
    let lenDes=form_modifica.descrizione.length;
    let lenU=form_modifica.modouso.length;
    let lenS=form_modifica.scopo.length;
    let lenDef=form_modifica.definizione.length;
    let lenOss=form_modifica.osservazioni.length;

    // Variabile per caricamento reperto completato
    let loaded

    // Import select e funzione redirect aggiunta/modifica autore
    import SelectAutori from "./Select_Autori_M.svelte";

    // Gestione select materiali
    import SelectMateriali from "./Select_Materiali_M.svelte";
    import { numero_select_materiali_m } from "../js/data-select.js"
    let select_materiali = writable([]);

    function aggiungi_select_materiali() {
        $numero_select_materiali_m += 1;
        select_materiali.update(comp => [...comp, {id: $numero_select_materiali_m}]);
    }
    
    function rimuovi_select_materiali() {
        select_materiali.update(comp => comp.filter(c => c.id !== $numero_select_materiali_m));
        form_modifica.codmateriale.pop()
        if ($numero_select_materiali_m > 0) {
            $numero_select_materiali_m -= 1
        }
        else {
            $numero_select_materiali_m = 0
        }
    }

    function carica_select_materiali() {
        for (var i = 0; i < form_modifica.codmateriale.length; i++) {
            $numero_select_materiali_m += 1;
            select_materiali.update(comp => [...comp, {id: $numero_select_materiali_m}]);
        }
    }

    // Gestione select tipo misure
    import SelectTipomisura from "./Select_Tipomisura_M.svelte"
    import { numero_select_tipomisure_m } from "../js/data-select.js"
    let select_tipomisure = writable([]);

    function aggiungi_select_tipomisure() {
        $numero_select_tipomisure_m += 1;
        select_tipomisure.update(comp => [...comp, {id: $numero_select_tipomisure_m}]);
    }

    function rimuovi_select_tipomisure() {
        select_tipomisure.update(comp => comp.filter(c => c.id !== $numero_select_tipomisure_m));
        form_modifica.valore.pop()
        form_modifica.tipomisura.pop()
        if ($numero_select_tipomisure_m > 0) {
            $numero_select_tipomisure_m -= 1
        }
        else {
            $numero_select_tipomisure_m = 0
        }
    }

    function carica_select_tipomisure() {
        for (var i = 0; i < form_modifica.tipomisura.length; i++) {
            $numero_select_tipomisure_m += 1;
            select_tipomisure.update(comp => [...comp, {id: $numero_select_tipomisure_m}]);
        }
    }

    // Caricamento informazioni durante l'inizializzazione del component
    let autore_component
    onMount (async() => {
        autore_component.update(form_modifica.codautore)
        carica_select_materiali()
        carica_select_tipomisure()

        loaded = true

		var annoInizio_input =  document.getElementById('annoInizio');
		var annoFine_input =  document.getElementById('annoFine');
	
		var valoreAnnIniz = 0
		const minMaxAnnIniz = () => {
			if(annoInizio_input.value > 999 ){
				annoInizio_input.value = valoreAnnIniz;
			}
			valoreAnnIniz = annoInizio_input.value;
		}
		annoInizio_input.addEventListener("keypress", minMaxAnnIniz);
		
		var valoreAnnFin = 0
		const minMaxAnnFin = () => {
			if(annoFine_input.value > 999 ){
				annoFine_input.value = valoreAnnFin;
			}
			valoreAnnFin = annoFine_input.value;
		}

		annoFine_input.addEventListener("keypress", minMaxAnnFin);
	

    })

    // Stile righe e colonne per avere i components ordinati
    let styleGrid = "width: 80%; margin-top: 2%; margin-right: 5%; margin-left: auto; padding: 0px"
    let styleRow = "margin: 0px;"
	let styleColumn = "font-size: 18px; margin-right:0; padding: 0px; padding-top: 10px"

    // Aggiungi zero al codice relativo
    function aggiungiZero(input) {
        if (form_modifica.codrelativo.length < 1) {
            form_modifica.codrelativo = ("000");
        }
        if (form_modifica.codrelativo.length < 2) {
            form_modifica.codrelativo = ("00" + form_modifica.codrelativo).slice(-3);
        }
        if (form_modifica.codrelativo,length < 3) {
            form_modifica.codrelativo = ("0" + form_modifica.codrelativo).slice(-3);
        }
        if (form_modifica.codrelativo,length > 3) {
            form_modifica.codrelativo = form_modifica.codrelativo[0, 3]
        }
    }

</script>


<!--  Inizio TAG griglia migliorare la gestione della grafica -->
<Grid style= {styleGrid} >

    <!-- Nome reperto -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Nome reperto:</Column>
        <Column style={styleColumn}>
            <TextInput bind:value={form_modifica.nome} placeholder="Nome reperto" maxlength='50' oninput="document.getElementById('lenNome').innerHTML = this.value.length" />
            <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/50</div>
            <div id="lenNome" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenN}</div>
        </Column>
    </Row>

    <!-- Nome reperto -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Codice relativo:</Column>
        <Column style={styleColumn}>
            <TextInput type="text" maxlength="3" required bind:value={form_modifica.codrelativo} placeholder="Codice relativo" on:blur={aggiungiZero(this)}/>
        </Column>
    </Row>

    <!-- Sezione del reperto -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Sezione:</Column>
        <Column style={styleColumn}>
            <Select selected={form_modifica.sezione} on:change={(e) => form_modifica.sezione = e.target.value} hideLabel>
                <SelectItem value="" text=" -- SELEZIONARE --" />
                <SelectItem value="I" text="Informatica" />
                <SelectItem value="E" text="Elettrotecnica" />
                <SelectItem value="S" text="Scienze" />
                <SelectItem value="M" text="Meccanica" />
            </Select>
        </Column>
    </Row>

    <!-- Anno inizio uso del reperto -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Anno inizio uso: </Column>
        <Column style={styleColumn}>
            <TextInput bind:value={form_modifica.annoiniziouso} id = "annoInizio" type="number" step="1" hideLabel placeholder="YYYY" />
        </Column>
    </Row>

    <!-- Anno fine uso del reperto -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Anno fine uso: </Column>
        <Column style={styleColumn}>
            <TextInput bind:value={form_modifica.annofineuso} id = "annoFine" type="number" step="1" hideLabel placeholder="YYYY" />
        </Column>
    </Row>

    <!-- Stato del reperto -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Stato: </Column>
        <Column style={styleColumn}>
            <Select selected={form_modifica.stato.toString()} on:change={(e) => form_modifica.stato = e.target.value} hideLabel>
                <SelectItem value="" text=" -- SELEZIONARE --" />
                <SelectItem value="1" text="Pessimo" />
                <SelectItem value="2" text="Molto usato" />
                <SelectItem value="3" text="Usato" />
                <SelectItem value="4" text="Buono" />
                <SelectItem value="5" text="Eccellente" />
            </Select>
        </Column>
    </Row>

    <!-- Tipo acquisizione del reperto -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Tipo acquisizione: </Column>
        <Column style={styleColumn}>
            <Select selected={form_modifica.tipoacquisizione} on:change={(e) => form_modifica.tipoacquisizione = e.target.value} hideLabel>
                <SelectItem value="" text=" -- SELEZIONARE --" />
                <SelectItem value="D" text="Donazione" />
                <SelectItem value="A" text="Acquisto" />
                <SelectItem value="R" text="Rubato" />
                <SelectItem value="T" text="Trovato" />
                <SelectItem value="C" text="Costruito" />
                <SelectItem value="O" text="Altro" />
            </Select>
        </Column>
    </Row>

    <!-- Select autori del reperto -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Autore: 
            <Button 
            tooltipPosition="right"
            tooltipAlignment="end"
            iconDescription="Aggiungi autore"
            icon={Add}
            size="medium" 
            kind="ghost" 
            on:click={redirectAutore}
        />
        </Column>
        <Column style={styleColumn}>
            <SelectAutori bind:this={autore_component} />
        </Column>
    </Row>

    <!-- Select materiali del reperto -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Materiali:
            <Button 
            tooltipPosition="right"
            tooltipAlignment="end"
            iconDescription="Aggiungi materiale"
            icon={Add}
            size="medium" 
            kind="ghost" 
            on:click={redirectMateriale}
            />
        </Column>
        <Column style={styleColumn}>
            {#each $select_materiali as component, index}
                <SelectMateriali valore={form_modifica.codmateriale[index]}/>
            {/each}
            <Button kind="ghost" on:click={aggiungi_select_materiali}>+</Button>
            <Button kind="ghost" on:click={rimuovi_select_materiali}>-</Button>
        </Column>
    </Row>

    <!-- Input dimensioni e select tipomisura del reperto -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Dimensioni: 
            <Button 
            tooltipPosition="right"
            tooltipAlignment="end"
            iconDescription="Aggiungi misura"
            icon={Add}
            size="medium" 
            kind="ghost" 
            on:click={redirectMisura}
            />
        </Column>
        <Column style={styleColumn}>
            {#each $select_tipomisure as component, index}
                <SelectTipomisura valore={form_modifica.valore[index]} tipomisura={form_modifica.tipomisura[index]}/>
            {/each}
            <Button kind="ghost" on:click={aggiungi_select_tipomisure}>+</Button>
            <Button kind="ghost" on:click={rimuovi_select_tipomisure}>-</Button>
        </Column>
    </Row>

    <!-- Descrizione del reperto  -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Descrizione: </Column>
        <Column style={styleColumn}>
            <TextArea bind:value={form_modifica.descrizione}
            rows={5}
            placeholder="Completare il campo..."
            maxlength='600' oninput="document.getElementById('lenDes').innerHTML = this.value.length" />
            <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/600</div>
            <div id="lenDes" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenDes}</div>
        </Column>
    </Row>

    <!-- Modo d'uso del reperto  -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Modo d'uso: </Column>
        <Column style={styleColumn}>
            <TextArea bind:value={form_modifica.modouso}
            rows={5}
            placeholder="Completare il campo..."
            maxlength='600' oninput="document.getElementById('lenUso').innerHTML = this.value.length" />
            <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/600</div>
            <div id="lenUso" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenU}</div>
        </Column>
    </Row>

    <!-- Scopo del reperto  -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Scopo: </Column>
        <Column style={styleColumn}>
            <TextArea bind:value={form_modifica.scopo}
            rows={5}
            placeholder="Completare il campo..."
            maxlength='600' oninput="document.getElementById('lenScopo').innerHTML = this.value.length" />
            <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/600</div>
            <div id="lenScopo" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenS}</div>
        </Column>
    </Row>

    <!-- Definizione del reperto  -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Definizione: </Column>
        <Column style={styleColumn}>
            <TextArea bind:value={form_modifica.definizione}
            rows={5}
            placeholder="Completare il campo..."
            maxlength='250' oninput="document.getElementById('lenDef').innerHTML = this.value.length" />
            <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/250</div>
            <div id="lenDef" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenDef}</div>
        </Column>
    </Row>

    <!-- Osservazioni sul reperto  -->
    <Row style={styleRow}>
        <Column style={styleColumn}>Osservazioni: </Column>
        <Column style={styleColumn}>
            <TextArea bind:value={form_modifica.osservazioni}
            rows={5}
            placeholder="Completare il campo..."
            maxlength='600' oninput="document.getElementById('lenOss').innerHTML = this.value.length" />
            <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/600</div>
            <div id="lenOss" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenOss}</div>
        </Column>
    </Row>

<!-- Chiusura griglia -->
</Grid>
