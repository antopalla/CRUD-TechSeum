<script>
    import { TextInput } from "carbon-components-svelte";
    import { Select, SelectItem } from "carbon-components-svelte";
    import { Grid, Row, Column } from "carbon-components-svelte";
    import { TextArea } from "carbon-components-svelte";
    import { Button } from "carbon-components-svelte";
    import { writable } from "svelte/store";
    import { goto } from "$app/navigation";


    // SELECT MATERIALI
    import SelectMateriali from "./Select_Materiali.svelte";
    let numero_select_materiali = 0;
    let select_materiali = writable([]);

    function aggiungi_select_materiali() {
        numero_select_materiali += 1;
        select_materiali.update(comp => [...comp, {id: numero_select_materiali}]);
    }
    function aggiungi_nuovo_autore()
    {
        goto('/autore')
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

    // SELECT TIPO MISURE
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

    // SELECT AUTORI
    import SelectAutori from "./Select_Autori.svelte";


    //queste sono le funzioni che permettono di far sparire o apparire il testo se si clicca sulla sua casella (handleMousemove,normale)
    function handleMousemove(e) {
		e.target.placeholder=""
	}
    
    function normale(e){
        if(e.target.name=="NOME"){
            e.target.placeholder="NOME REPERTO"
        }
        if(e.target.name=="Aiu"){
            e.target.placeholder="Anno inizio uso"
        }
        if(e.target.name=="Afu"){
            e.target.placeholder="Anno fine uso"
        }
        if(e.target.name=="Afu"){
            e.target.placeholder="Anno fine uso"
        }
        if(e.target.name=="Materiale"){
            e.target.placeholder="Inserire Materiale"
        }
        if(e.target.name=="Descrizione"){
            e.target.placeholder="Scrivere una descrizione : "
        }
        if(e.target.name=="Mod_uso"){
            e.target.placeholder="Modo d'uso : "
        }
        if(e.target.name=="Dimensione"){
            e.target.placeholder="Inserire dimensione :"
        }
        if(e.target.name=="Autore"){
            e.target.placeholder="Specificare autore"
        }
    } 
    
    function normale_descrizione(e){
        e.target.placeholder="Scrivere una descrizione : "
        
    }
    function normale_modo_d_uso(e){
        e.target.placeholder="Modo d'uso : "
        
    }
    function normale_ins_mat(e){
        e.target.placeholder="Inserire matriale"
        
    }
    let styleGrid = "width : 50% ; margin-right: 0px; margin-left: auto; padding:0px"
	let styleColumn = "font-size: 18px;margin-right:0; padding: 0px ; padding-top: 10px"
</script>


<!--il dev l di sotto di questo commento contiene la casella di testo dove si va a specificare il nome del reperto da aggungere-->
<!--css del dev contenente i campi da riempire per descrivere l'oggetto-->
<style>
    .container_dx{
        margin: 0px;
		width: 50%;
    }
</style>
<!--Il dev sottostante contiene le informazioni principali da dare per aggiungere il reperto-->
<dev class="container_dx" style="width : 50% ; margin-right:0px; padding:0px; padding-top:20px;margin-left: 50%">
    <TextInput on:click={handleMousemove} on:blur={normale} style="font-size:30px;text-align:center; width: 50% ; margin-left: 50%;" name="NOME" hideLabel labelText="User name" placeholder="NOME REPERTO" />
	<Grid style= {styleGrid} >
        <Row style="margin: 0px;">
            <Column style={styleColumn} >Sezione:</Column>
            <Column style={styleColumn} ><!--sm md lg modificano la dimensione della colonna la documentazzione Vattela a vedere coglione po per il resto è tutto
            uguale quindi attiva il cervello-->
				<Select hideLabel labelText="Carbon theme">
					<SelectItem value="Informatica" text="Informatica" />
					<SelectItem value="Elettrotecnica" text="Elettrotecnica" />
					<SelectItem value="Scienze" text="Scienze" />
					<SelectItem value="Meccanica" text="Meccanica" />
				</Select>
            </Column>
        </Row>
        <!---->
        <Row style="margin: 0px;">
            <Column style={styleColumn}>Anno inizio uso :</Column>
            <Column style={styleColumn}>
                <TextInput on:click={handleMousemove} on:blur={normale} name="Aiu" hideLabel labelText="Anno inizio uso" placeholder="Anno inizio uso" />
            </Column>
        </Row>
        <Row style="margin: 0px;">
            <Column style={styleColumn}>Anno fine uso :</Column>
            <Column style={styleColumn}>
                <TextInput on:click={handleMousemove} on:blur={normale} name="Afu" hideLabel labelText="Anno fine uso" placeholder="Anno fine uso" />
            </Column>
        </Row>
        <Row style="margin: 0px;">
            <Column style={styleColumn}>Stato :</Column>
            <Column style={styleColumn}>
                <Select hideLabel labelText="Carbon theme" selected="g10">
                <SelectItem value="1" text="Pessimo" />
                <SelectItem value="2" text="Molto usato" />
                <SelectItem value="3" text="Usato" />
                <SelectItem value="4" text="Buono" />
                <SelectItem value="5" text="Eccellente" />
            </Select>
            </Column>
        </Row>
        <Row style="margin: 0px;">
            <Column style={styleColumn}>Tipo acquisizione :</Column>
            <Column style={styleColumn}>
                <Select hideLabel labelText="Carbon theme" selected="g10">
                <SelectItem value="D" text="Donazione" />
                <SelectItem value="A" text="Acquisito" />
                <SelectItem value="R" text="Rubato" />
                <SelectItem value="T" text="Trovato" />
                <SelectItem value="C" text="Costruito" />
                <SelectItem value="O" text="Altro" />
            </Select>
            </Column>
        </Row>

        <!-- SELECT AUTORI -->
        <Row style="margin: 0px;">
            <Column style={styleColumn}>Autore :</Column>
            <Column style={styleColumn}>
                <SelectAutori />
                <Button kind="ghost" on:click={aggiungi_nuovo_autore}>+</Button>
            </Column>
        </Row>

        <!-- SELECT MATERIALI -->
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

        <!-- INPUT DIMENSIONI E SELECT TIPOMISURA  -->
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
        <Row style="margin: 0px;">
            <Column style={styleColumn}>Descrizione :</Column>
            <Column style={styleColumn}>
                <TextArea on:click={handleMousemove} on:blur={normale}
                name="Descrizione"
                rows={10}
                placeholder="Scrivere una descrizione"
                />
            </Column>
        </Row>
        <Row style="margin: 0px;">
            <Column style={styleColumn}>Modo d'uso :</Column>
            <Column style={styleColumn}>
                <TextArea on:click={handleMousemove} on:blur={normale}
                name="Mod_uso"
                rows={10}
                placeholder="Modo d'uso"
                />
            </Column>
        </Row>
        
    </Grid>
</dev>