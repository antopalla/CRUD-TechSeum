<script>
    // IMPORT FROM SVELTE
    import { writable } from "svelte/store";
    import { goto } from "$app/navigation";

    // IMPORT FROM CARBON
    import { TextInput } from "carbon-components-svelte";
    import { Select, SelectItem } from "carbon-components-svelte";
    import { Grid, Row, Column } from "carbon-components-svelte";
    import { TextArea } from "carbon-components-svelte";
    import { Button } from "carbon-components-svelte";

    // Import select e redirect autore
    import SelectAutori from "./Select_Autori.svelte";

    function redirectAutore() {
        goto('/reperti/autore')
    }

    // Select materiali
    import SelectMateriali from "./Select_Materiali.svelte";
    let numero_select_materiali = 0;
    let select_materiali = writable([]);

    function aggiungi_select_materiali() {
        numero_select_materiali += 1;
        select_materiali.update(comp => [...comp, {id: numero_select_materiali}]);
    }
    
    function rimuovi_select_materiali() {
        select_materiali.update(comp => comp.filter(c => c.id !== numero_select_materiali));
        if (numero_select_materiali > 0) {
            numero_select_materiali -= 1
        }
        else {
            numero_select_materiali = 0
        }
    }

    // Select tipo misure
    import SelectTipomisura from "./Select_Tipomisura.svelte"
    let numero_select_tipomisure = 0;
    let select_tipomisure = writable([]);

    function aggiungi_select_tipomisure() {
        numero_select_tipomisure += 1;
        select_tipomisure.update(comp => [...comp, {id: numero_select_tipomisure}]);
    }

    function rimuovi_select_tipomisure() {
        select_tipomisure.update(comp => comp.filter(c => c.id !== numero_select_tipomisure));
        if (numero_select_tipomisure > 0) {
            numero_select_tipomisure -= 1
        }
        else {
            numero_select_tipomisure = 0
        }
    }

    // Far sparire il placeholder quando si clicca con il mouse
    function handleMousemove(e) {
		e.target.placeholder=""
	}
    
    // Far apparire il placeholder quando si è fuori dal target
    function normale(e){
        if(e.target.name=="nome"){
            e.target.placeholder="Nome reperto"
        }
        else if(e.target.name=="aiu"){
            e.target.placeholder="YYYY"
        }
        else if(e.target.name=="afu"){
            e.target.placeholder="YYYY"
        }
        else {
            e.target.placeholder="Completare il campo..."
        }
    } 

    // Stile righe e colonne per avere i components ordinati
    let styleGrid = "width : 50% ; margin-right: 0px; margin-left: auto; padding:0px"
	let styleColumn = "font-size: 18px;margin-right:0; padding: 0px ; padding-top: 10px"


    // API per creazione reperto
    // Import librerie
    import { creaReperto } from "../js/functions.js";
    import { getCurrentDateTime } from "../js/functions.js";
    import { form } from "../js/const.js";

    // Handle del form e invio dati
    const handleForm = async () => {
        form.datacatalogazione = getCurrentDateTime();
        console.log(form)
        //await creaReperto();
        //goto("/reperti");
    };

</script>

<!-- CSS PER I TAG -->
<style>
    .container_dx{
        margin: 0px;
		width: 50%;
    }
</style>

<!-- Form del reperto -->
<form on:submit|preventDefault={handleForm}>

    <!-- Informazioni del reperto -->
    <dev class="container_dx" style="width : 50% ; margin-right:0px; padding:0px; padding-top:20px;margin-left: 50%">

        <!-- Nome reperto -->
        <TextInput bind:value={form.nome} on:click={handleMousemove} on:blur={normale} style="font-size:30px; text-align:center; width: 50% ; margin-left: 50%;" name="nome" placeholder="Nome reperto" />

        <!--  Inizio TAG griglia migliorare la gestione della grafica -->
        <Grid style= {styleGrid} >

            <!-- Sezione del reperto -->
            <Row style="margin: 0px;">
                <Column style={styleColumn}>Sezione:</Column>
                <Column style={styleColumn}>
                    <Select hideLabel bind:value={form.sezione}>
                        <SelectItem value="I" text="Informatica" />
                        <SelectItem value="E" text="Elettrotecnica" />
                        <SelectItem value="S" text="Scienze" />
                        <SelectItem value="M" text="Meccanica" />
                    </Select>
                </Column>
            </Row>

            <!-- Anno inizio uso del reperto -->
            <Row style="margin: 0px;">
                <Column style={styleColumn}>Anno inizio uso: </Column>
                <Column style={styleColumn}>
                    <TextInput bind:value={form.annoiniziouso} type="number" min="1500" max="2099" step="1" on:click={handleMousemove} on:blur={normale} name="aiu" hideLabel placeholder="YYYY" />
                </Column>
            </Row>

            <!-- Anno fine uso del reperto -->
            <Row style="margin: 0px;">
                <Column style={styleColumn}>Anno fine uso: </Column>
                <Column style={styleColumn}>
                    <TextInput bind:value={form.annofineuso} type="number" min="1500" max="2099" step="1" on:click={handleMousemove} on:blur={normale} name="afu" hideLabel placeholder="YYYY" />
                </Column>
            </Row>

            <!-- Stato del reperto -->
            <Row style="margin: 0px;">
                <Column style={styleColumn}>Stato: </Column>
                <Column style={styleColumn}>
                    <Select bind:value={form.stato} hideLabel>
                        <SelectItem value="1" text="Pessimo" />
                        <SelectItem value="2" text="Molto usato" />
                        <SelectItem value="3" text="Usato" />
                        <SelectItem value="4" text="Buono" />
                        <SelectItem value="5" text="Eccellente" />
                    </Select>
                </Column>
            </Row>

            <!-- Tipo acquisizione del reperto -->
            <Row style="margin: 0px;">
                <Column style={styleColumn}>Tipo acquisizione: </Column>
                <Column style={styleColumn}>
                    <Select bind:value={form.tipoacquisizione} hideLabel selected="g10">
                        <SelectItem value="D" text="Donazione" />
                        <SelectItem value="A" text="Acquisito" />
                        <SelectItem value="R" text="Rubato" />
                        <SelectItem value="T" text="Trovato" />
                        <SelectItem value="C" text="Costruito" />
                        <SelectItem value="O" text="Altro" />
                    </Select>
                </Column>
            </Row>

            <!-- Select autori del reperto -->
            <Row style="margin: 0px;">
                <Column style={styleColumn}>Autore :</Column>
                <Column style={styleColumn}>
                    <SelectAutori />
                    <Button kind="ghost" on:click={redirectAutore}>+</Button>
                </Column>
            </Row>

            <!-- Select materiali del reperto -->
            <Row style="margin: 0px;">
                <Column style={styleColumn}>Materiali :</Column>
                <Column style={styleColumn}>
                    {#each $select_materiali as component}
                        <SelectMateriali id={component.id} />
                    {/each}
                    <Button kind="ghost" on:click={aggiungi_select_materiali}>+</Button>
                    <Button kind="ghost" on:click={rimuovi_select_materiali}>-</Button>
                </Column>
            </Row>

            <!-- Input dimensioni e select tipomisura del reperto -->
            <Row style="margin: 0px;">
                <Column style={styleColumn}>Dimensioni :</Column>
                <Column style={styleColumn}>
                    {#each $select_tipomisure as component}
                        <SelectTipomisura id={component.id} />
                    {/each}
                    <Button kind="ghost" on:click={aggiungi_select_tipomisure}>+</Button>
                    <Button kind="ghost" on:click={rimuovi_select_tipomisure}>-</Button>
                </Column>
            </Row>

            <!-- Descrizione del reperto  -->
            <Row style="margin: 0px;">
                <Column style={styleColumn}>Descrizione: </Column>
                <Column style={styleColumn}>
                    <TextArea bind:value={form.descrizione} on:click={handleMousemove} on:blur={normale}
                    name="descrizione"
                    rows={10}
                    placeholder="Completare il campo..."
                    />
                </Column>
            </Row>

            <!-- Modo d'uso del reperto  -->
            <Row style="margin: 0px;">
                <Column style={styleColumn}>Modo d'uso: </Column>
                <Column style={styleColumn}>
                    <TextArea bind:value={form.modouso} on:click={handleMousemove} on:blur={normale}
                    name="moduso"
                    rows={10}
                    placeholder="Completare il campo..."
                    />
                </Column>
            </Row>

            <Row style="margin: 0px;">
                <Button type='submit' style='background-color:#456266; font-size:20px; padding:20px'>Crea reperto</Button>
            </Row>
        
        <!-- Chiusura griglia -->
        </Grid>
    </dev>
</form>