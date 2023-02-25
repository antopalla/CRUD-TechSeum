<script>
  import { Grid, Row, Column, TextArea, TextInput, Select, SelectItem, Button } from "carbon-components-svelte";
  import { form } from "../js/const.js"
  import { writable } from "svelte/store"
  import { handleFileUpload } from "../js/functions.js"
  import { handleFileDelete } from "../js/functions.js"

  let all_images = [];
  let copertina = [];
  let galleria= [];


//Funzione per la visualizzazione dell'immagine di copertina
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

  export const caricaArray = () => {
    for (let i=0; i<form.link.length; i++) {
      handleFileDelete(form.link[i])
    }
    form.nmedia.length=0
    form.tipo.length=0
    form.link.length=0
    form.fonte.length=0

    all_images=copertina.concat(galleria);
    
    for (let i=0; i<all_images.length; i++) {
      form.nmedia.push(i)
      form.tipo.push("F")
      form.link.push(all_images[i]["name"])
      form.fonte.push("Propria")
      handleFileUpload(all_images[i])
    }
  }

  function AzzeraCopertina(){
    all_images.length=0
    copertina.length=0;
  }
  function AzzeraGalleria() {
    all_images.length=0
    galleria.length=0;
  }

  // Select nparte
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

<!-- Inserimento delle immagini -->
<Grid style={styleGrid}>

  <Row style={styleRow}>

    <Column style={styleColumn}>
      <label for="cover-image">Immagine di copertina:</label><br>
      <input type="file" id="cover-image" name="cover-image" accept="image/*" on:change={previewCoverImage}><br><br>
      <!-- svelte-ignore a11y-missing-attribute -->
      <img id="cover-image-preview"><br><br>
    </Column>

    <Column style={styleColumn}>
      <label for="gallery-images">Galleria di immagini:</label><br>
      <input type="file" id="gallery-images" name="gallery-images" accept="image/*" on:change={previewGalleryImages} multiple><br><br>
      <div id="gallery-images-preview"></div><br><br>   
    </Column>
  </Row>

  <Row style={styleRow}>

    <Column style={styleColumn}>Didascalia:</Column>
    <Column style={styleColumn}>
      <TextArea bind:value={form.didascalia}
          rows={5}
          hideLabel
          placeholder="Completare il campo..."
        />
      </Column>
  </Row>
  
  <Row style={styleRow}>

    <Column style={styleColumn}>Lingua didascalia:</Column>
    <Column style={styleColumn}>
      <Select hideLabel on:change={(e) => form.lingua = e.target.value}>
        <SelectItem value="" text=" -- SELEZIONARE -- " />
        <SelectItem value="IT" text=" Italiano " />
        <SelectItem value="EN" text=" Inglese " />
      </Select>
    </Column>
  </Row>

  <Row style={styleRow}>

    <Column style={styleColumn}>Denominazione storica:</Column>
    <Column style={styleColumn}>
      <TextArea bind:value={form.denominazionestorica}
      rows={5}
      hideLabel
      placeholder="Completare il campo..."
      />
    </Column>
  </Row>

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

  <Row style={styleRow}>

    <Column style={styleColumn}>Acquisito da:</Column>
    <Column style={styleColumn}>
      <TextInput bind:value={form.dasoggetto} placeholder="Completare il campo..." />
    </Column>
  </Row>

  <Row style={styleRow}>

    <Column style={styleColumn}>Quantità acquisizione:</Column>
    <Column style={styleColumn}>
      <TextInput type="number" bind:value={form.quantita} placeholder="Completare il campo..." />
    </Column>
  </Row>

</Grid>
