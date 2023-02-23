<script>
    import { Select, SelectItem, TextInput, Column, Row } from "carbon-components-svelte";
    import { url_path } from "../js/const.js"
    import { onMount } from 'svelte'
    import { writable } from 'svelte/store'

    let misure = writable([]);

    onMount(async() => {
        const url = 'http://' + url_path + '/back-end_development/misura/get_misure.php'
        let res = await fetch(url)
        res = await res.json() // Contiene l'oggetto che a sua volta contiene l'array preso dal JSON

        $misure = res.data // Contiene l'array contenuto nell'oggetto; il simbolo $ indica come la variabile sia presa dall'import 
                            // del JavaScript, Variabile Front-End globale per i reperti
        
    })

    function handleMousemove(e) {
		e.target.placeholder=""
	}

    function normale(e){
        e.target.placeholder="Inserire valore: "
    } 

</script>

<Row>
    <Column>
        <TextInput on:click={handleMousemove} on:blur={normale} name="Dimensione" hideLabel labelText="Dimensione" placeholder="Inserire valore: " />
    </Column>
    <Column>
        <Select hideLabel labelText="Carbon theme" selected="cm">
            {#each $misure as misura}
                <SelectItem value="{misura.id}" text="{misura.unitadimisura}" />
            {/each}
        </Select>
    </Column>
</Row>

