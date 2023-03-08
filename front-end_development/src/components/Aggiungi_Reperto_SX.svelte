<script>
  // IMPORT FROM SVELTE
  import { writable } from "svelte/store"

  // IMPORT FROM CARBON
  import { Grid, Row, Column, TextArea, TextInput, Select, SelectItem, Button } from "carbon-components-svelte";

  // IMPORT VARIABILI FORM E FUNZIONI
  import { form } from "../js/const.js"
  import { handleFileUpload } from "../js/functions.js"
  import { handleFileDelete } from "../js/functions.js"

  // VARIABILI PER LA GESTIONE DELLA PREVIEW E DELLE IMMAGINI
  let all_images = [];
  let copertina = [];
  let galleria= [];

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
    switch(form.sezione) {
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

    for (let i=0; i<form.link.length; i++) {
      handleFileDelete(form.link[i])
    }
    form.nmedia.length=0
    form.tipo.length=0
    form.link.length=0
    form.fonte.length=0

    all_images=copertina.concat(galleria);
 
    for (let i=0; i<all_images.length; i++) {
      nomiImmagini[i] = tmp+"-"+form.codrelativo+"."+i+".jpg"
      form.nmedia.push(i)
      form.tipo.push("F")
      form.link.push(nomiImmagini[i])
      form.fonte.push("Propria")
      handleFileUpload(all_images[i], tmp, form.codrelativo, i)
    }
  }

  // Funzioni per svuotare gli array
  function AzzeraCopertina(){
    all_images.length=0
    copertina.length=0;
  }
  function AzzeraGalleria() {
    all_images.length=0
    galleria.length=0;
  }

  // Gestione TextInput inserimento parti
  import InserimentoParti from "./Inserimento_Parti.svelte";
  import { numero_inserimento_parti } from "../js/data-select.js"
  let inserimento_parti = writable([]);

  function aggiungi_inserimento_parti() {
      $numero_inserimento_parti += 1;
      inserimento_parti.update(comp => [...comp, {id: $numero_inserimento_parti}]);
  }
    
  function rimuovi_inserimento_parti() {
    inserimento_parti.update(comp => comp.filter(c => c.id !== $numero_inserimento_parti));
    form.nparte.pop()
    form.nomeparte.pop()
      if ($numero_inserimento_parti > 0) {
          $numero_inserimento_parti -= 1
      }
      else {
          $numero_inserimento_parti = 0
      }
  }

  // Stile righe e colonne per avere i components ordinati
  let styleGrid = "width : 100%; margin-top: 2%; margin-right: auto; margin-left: 5%; padding: 0px;"
  let styleRow = "margin: 0px;"
	let styleColumn = "width : 50%; font-size: 18px; margin-right: 15%; padding: 0px; padding-top: 10px;"

</script>


<!--  Inizio TAG griglia migliorare la gestione della grafica -->
<Grid style={styleGrid}>

  <!--  Preview immagine di copertina -->
  <Row style={styleRow}>
    <Column style={styleColumn}>
      <label for="cover-image">Immagine di copertina:</label><br>
      <input type="file" id="cover-image" name="cover-image" accept="image/jpg" on:change={previewCoverImage}><br><br>
      <!-- svelte-ignore a11y-missing-attribute -->
      <img id="cover-image-preview"><br><br>
    </Column>
  </Row>

  <!--  Preview galleria di immagini -->
  <Row style={styleRow}>
    <Column style={styleColumn}>
      <label for="gallery-images">Galleria di immagini:</label><br>
      <input type="file" id="gallery-images" name="gallery-images" accept="image/jpg" on:change={previewGalleryImages} multiple><br><br>
      <div id="gallery-images-preview"></div><br><br>   
    </Column>
  </Row>

  <!--  Didascalia del reperto -->
  <Row style={styleRow}>
    <Column style={styleColumn}>Didascalia:</Column>
    <Column style={styleColumn}>
      <TextArea maxlength="600" bind:value={form.didascalia}
          rows={5}
          hideLabel
          placeholder="Completare il campo..."
          oninput="document.getElementById('charCount').innerHTML = this.value.length"
        />
        <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/600</div>
         <div id="charCount" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">0</div>
      </Column>
  </Row>
  
  <!--  Lingua didascalia del reperto -->
  <Row style={styleRow}>
    <Column style={styleColumn}>Lingua didascalia:</Column>
    <Column style={styleColumn}>
      <Select selected={form.lingua} hideLabel on:change={(e) => form.lingua = e.target.value}>
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
      <TextArea maxlength="600" bind:value={form.denominazionestorica}
      rows={5}
      hideLabel
      placeholder="Completare il campo..."
      oninput="document.getElementById('charCount1').innerHTML = this.value.length"
      />
      <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/600</div>
      <div id="charCount1" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">0</div>
    </Column>
  </Row>

  <!--  Parti che compongono il reperto -->
  <Row style={styleRow}>
    <Column style={styleColumn}>Parti che compongono il reperto:</Column>
    <Column style={styleColumn}>
      {#each $inserimento_parti as component}
              <InserimentoParti />
      {/each}
      <Button kind="ghost" on:click={aggiungi_inserimento_parti}>+</Button>
      <Button kind="ghost" on:click={rimuovi_inserimento_parti}>-</Button>
    </Column>
  </Row>

  <!--  Acquisizione da parte di del reperto -->
  <Row style={styleRow}>
    <Column style={styleColumn}>Acquisito da:</Column>
    <Column style={styleColumn}>
      <TextInput maxlength="50" bind:value={form.dasoggetto} placeholder="Completare il campo..." 
        oninput="document.getElementById('charCount2').innerHTML = this.value.length" />
         <div style="font-size: 11px; margin-top: 10px;text-align: right; float: right">/50</div>
         <div id="charCount2" style="font-size: 11px; margin-top: 10px;text-align: right; float: right">0</div>
    </Column>
    
  </Row>

  <!--  Quantità acquisizione del reperto -->
  <Row style={styleRow}>
    <Column style={styleColumn}>Quantità acquisizione:</Column>
    <Column style={styleColumn}>
      <TextInput  type="number" max="999" min="0" bind:value={form.quantita} placeholder="Completare il campo..." />
    </Column>
  </Row>

<!-- Chiusura griglia -->
</Grid>
