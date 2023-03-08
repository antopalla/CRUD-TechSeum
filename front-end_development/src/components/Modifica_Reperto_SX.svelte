<script>
    // IMPORT FROM SVELTE
    import { writable } from "svelte/store"
    import { onMount } from 'svelte'
  
    // IMPORT FROM CARBON
    import { Grid, Row, Column, TextArea, TextInput, Select, SelectItem, Button, ImageLoader, InlineLoading } from "carbon-components-svelte";
  
    // IMPORT VARIABILI FORM E FUNZIONI
    import { form_modifica } from "../js/const.js"
    import { handleFileUpload } from "../js/functions.js"
    import { handleFileDelete } from "../js/functions.js"
    import { fetchFile, fetchFileBlob } from '../js/functions.js';
  
    // VARIABILI PER LA GESTIONE DELLA PREVIEW E DELLE IMMAGINI
    let all_images = [];
    let all_images_blob = [];
    let copertina = [];
    let galleria= [];
    let caricate = false;

    function imgCaricate () {
      caricate = true
    }

    // Variabile per caricamento reperto completato
    let loaded
  
    // Visualizzazione preview dell'immagine di copertina
    function previewCoverImage(event) {
        AzzeraCopertina();
        var reader = new FileReader();
        reader.onload = function() {
          var output = document.getElementById('cover-image-preview');
          output.src = reader.result;
          output.style.height='200px'
        }
        reader.readAsDataURL(event.target.files[0]);
        copertina.push(event.target.files[0]);
      }
  
    // Visualizzazione preview delle immagini di galleria
      function previewGalleryImages(event) {
        AzzeraGalleria();
        var previewContainer = document.getElementById('gallery-images-preview');
        previewContainer.innerHTML = '';
        var files = event.target.files;
        for (var i = 0; i < files.length; i++) {
          var file = files[i];
          galleria.push(file)
          var reader = new FileReader();
          reader.onload = (function(file) {
            return function() {
              var img = document.createElement('img');
              img.src = this.result;
              img.style.height='100px';
              img.style.width='100px';
              previewContainer.appendChild(img);
            };
          })(file);
        reader.readAsDataURL(file);
      }
    }
  
    // Caricamento immagini nel form da mandare al back-end
    export const caricaArray = () => {
      let nomiImmagini = []
      let tmp = ""
      switch(form_modifica.sezione) {
          case "E":
            tmp = "ELE";
            break
          case "I":
            tmp = "INF";
            break
          case "M":
            tmp = "MCC";
            break
          case "S":
            tmp = "SCI";
            break
      }

      for (let i=0; i<form_modifica.link.length; i++) {
        handleFileDelete(form_modifica.link[i])
      }

      form_modifica.nmedia.length=0
      form_modifica.tipo.length=0
      form_modifica.link.length=0
      form_modifica.fonte.length=0
      
      if (copertina.length != 0 && galleria.lenght != 0 && caricate) {
        all_images=copertina.concat(galleria);
      }
      
      for (let i=0; i<all_images.length; i++) {
        nomiImmagini[i] = tmp+"-"+form_modifica.codrelativo+"."+i+".jpg"
        form_modifica.nmedia.push(i)
        form_modifica.tipo.push("F")
        form_modifica.link.push(nomiImmagini[i])
        form_modifica.fonte.push("Propria")
        if (caricate) {
        handleFileUpload(all_images[i], tmp, form_modifica.codrelativo, i)
        }
        else {
          const myFile = new File([all_images_blob[i]], 'image.jpg', {type: all_images[i].type});
          handleFileUpload(myFile, tmp, form_modifica.codrelativo, i)
        }
      }
    }



    // Funzioni per svuotare gli array
    function AzzeraCopertina(){
      copertina.length=0;
    }
    function AzzeraGalleria() {
      galleria.length=0;
    }
  
    // Gestione TextInput inserimento parti
    import InserimentoParti from "./Inserimento_Parti_M.svelte";
    import { numero_inserimento_parti_m } from "../js/data-select.js"
    let inserimento_parti = writable([]);
  
    function aggiungi_inserimento_parti() {
        $numero_inserimento_parti_m += 1;
        inserimento_parti.update(comp => [...comp, {id: $numero_inserimento_parti_m}]);
    }
      
    function rimuovi_inserimento_parti() {
      inserimento_parti.update(comp => comp.filter(c => c.id !== $numero_inserimento_parti_m));
      form_modifica.nparte.pop()
      form_modifica.nomeparte.pop()
        if ($numero_inserimento_parti_m > 0) {
            $numero_inserimento_parti_m -= 1
        }
        else {
            $numero_inserimento_parti_m = 0
        }
    }

    function carica_inserimento_parti() {
      for (var i = 0; i < form_modifica.nparte.length; i++) {
        $numero_inserimento_parti_m += 1;
        inserimento_parti.update(comp => [...comp, {id: $numero_inserimento_parti_m}]);
      }
    }


    // Caricamento informazioni durante l'inizializzazione del component
    onMount (async() => {
      carica_inserimento_parti()

      copertina[0] = await fetchFile(form_modifica.link[0]);
      all_images[0] = await fetchFile(form_modifica.link[0]);
      all_images_blob[0] = await fetchFileBlob(form_modifica.link[0]);
      for (var i = 1; i < form_modifica.link.length; i++) {
        galleria[i] = await fetchFile(form_modifica.link[i]);
        all_images[i] = await fetchFile(form_modifica.link[i]);
        all_images_blob[i] = await fetchFileBlob(form_modifica.link[i]);
      }

      loaded = true
    })
  
    // Stile righe e colonne per avere i components ordinati
    let styleGrid = "width : 100%; margin-top: 2%; margin-right: auto; margin-left: 5%; padding: 0px;"
    let styleRow = "margin: 0px;"
    let styleColumn = "width : 50%; font-size: 18px; margin-right: 15%; padding: 0px; padding-top: 10px;"

    let lenD = form_modifica.didascalia.length;
    let lenDS = form_modifica.denominazionestorica.length;
    let lenA = 0 //form_modifica.dasoggetto.length;
  
</script>

{#if loaded}
  <!--  Inizio TAG griglia migliorare la gestione della grafica -->
  <Grid style={styleGrid}>

    <!--  Codassoluto del reperto -->
    <Row style={styleRow}>
      <Column style={styleColumn}>Cod. assoluto:</Column>
      <Column style={styleColumn}>
        <TextInput bind:value={form_modifica.codassoluto}
            hideLabel
            disabled={true}
          />
        </Column>
    </Row>
    
    <!--  Preview immagine di copertina -->
    <Row style={styleRow}>
      <Column style={styleColumn}>
        <label for="cover-image">Immagine di copertina:</label><br>
        <input type="file" id="cover-image" name="cover-image" accept="image/jpg" on:click={imgCaricate} on:change={previewCoverImage}><br><br>
        <!-- svelte-ignore a11y-missing-attribute -->
        <img src="{all_images[0]}" id="cover-image-preview" style="height: 200px"><br><br>
      </Column>
    </Row>

      <!--  Preview galleria di immagini -->
    <Row style={styleRow}>
      <Column style={styleColumn}>
        <label for="gallery-images">Galleria di immagini:</label><br>
        <input type="file" id="gallery-images" name="gallery-images" accept="image/jpg" on:click={imgCaricate} on:change={previewGalleryImages} multiple><br><br>
        <div id="gallery-images-preview">
          {#each all_images.slice(1) as a}
            <!-- svelte-ignore a11y-missing-attribute -->
            <img src={a} style="width: 100px; height: 100px;">
          {/each}
        </div><br><br>   
      </Column>
    </Row>

    <!--  Didascalia del reperto -->
    <Row style={styleRow}>
      <Column style={styleColumn}>Didascalia:</Column>
      <Column style={styleColumn}>
        <TextArea bind:value={form_modifica.didascalia} maxlength='600'
            rows={5}
            hideLabel
            placeholder="Completare il campo..."
            oninput="document.getElementById('charCount1').innerHTML = this.value.length"
           />
          <div  style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/600</div>
          <div id="charCount1" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenD}</div>

        </Column>
    </Row>
    
    <!--  Lingua didascalia del reperto -->
    <Row style={styleRow}>
      <Column style={styleColumn}>Lingua didascalia:</Column>
      <Column style={styleColumn}>
        <Select selected={form_modifica.lingua} hideLabel on:change={(e) => form_modifica.lingua = e.target.value}>
          <SelectItem value="" text=" -- SELEZIONARE -- " />
          <SelectItem value="IT" text=" Italiano " />
          <SelectItem value="EN" text=" Inglese " />
        </Select>
      </Column>
    </Row>

    <!--  Denominazione storica del reperto -->
    <Row style={styleRow}>
      <Column style={styleColumn}>Denominazione storica:</Column>
      <Column style={styleColumn}>
        <TextArea bind:value={form_modifica.denominazionestorica} maxlength='600'
        rows={5}
        hideLabel
        placeholder="Completare il campo..."
        oninput="document.getElementById('charCount3').innerHTML = this.value.length"
        />
        <div  style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/600</div>
        <div id="charCount3" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenDS}</div>
      </Column>
    </Row>

    <!--  Parti che compongono il reperto -->
    <Row style={styleRow}>
      <Column style={styleColumn}>Parti che compongono il reperto:</Column>
      <Column style={styleColumn}>
        {#each $inserimento_parti as component, index}
                <InserimentoParti valore={form_modifica.nomeparte[index]}/>
        {/each}
        <Button kind="ghost" on:click={aggiungi_inserimento_parti}>+</Button>
        <Button kind="ghost" on:click={rimuovi_inserimento_parti}>-</Button>
      </Column>
    </Row>

    <!--  Acquisizione da parte di del reperto -->
    <Row style={styleRow}>
      <Column style={styleColumn}>Acquisito da:</Column>
      <Column style={styleColumn}>
       <TextInput maxlength="50" bind:value={form_modifica.dasoggetto} placeholder="Completare il campo..." 
        oninput="document.getElementById('charCount2').innerHTML = this.value.length"
        />
        <div  style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/50</div>
        <div id="charCount2" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">{lenA}</div>
      </Column>
    </Row>

    <!--  Quantità acquisizione del reperto -->
    <Row style={styleRow}>
      <Column style={styleColumn}>Quantità acquisizione:</Column>
      <Column style={styleColumn}>
        <TextInput type="number" min={0} max={999} maxlength={3} bind:value={form_modifica.quantita} placeholder="Completare il campo..." />
      </Column>
    </Row>

  <!-- Chiusura griglia -->
  </Grid>
{:else}
  <p>Caricamento in corso...</p>
{/if}