<script>
  import { Column, Grid, TextArea, Select, SelectItem } from "carbon-components-svelte";
  import { form } from "../js/const.js"

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

  function caricaArray() {
    all_images=copertina.concat(galleria);
    for (let i=0; i<all_images.length; i++) {
        form.nmedia.push(i)
        form.tipo.push("F")
        form.link.push(all_images[i]["name"])
        form.fonte.push("stoca")
    }
  }

  function AzzeraCopertina(){
    copertina.length=0;
  }

  function AzzeraGalleria(){
    galleria.length=0;
  }


</script>

<style>

  .lingua{
    margin: right;
    margin-top: 20%;
    margin-left: 35%;
    width: 200px;
    position: absolute;
  }

  .did1{
      float: left;
      margin-top: 5%;
      margin-left: 35%;
      width: 200px;
      position:absolute;
  }

  .did2{
      margin: right;
      margin-top: 25%;
      margin-left: 35%;
      width: 200px;
      position: absolute;
  }

  .prove{
      margin: left;
      margin-top: 5%;
      margin-left: 10%;
      width: 300px;
      height: 300px;
      position: absolute;
  }

</style>

<!-- Inserimento delle immagini -->
<div class='prove'>
  <label for="cover-image">Immagine di copertina:</label><br>
  <input type="file" id="cover-image" name="cover-image" accept="image/*" on:change={previewCoverImage}><br><br>
  <!-- svelte-ignore a11y-missing-attribute -->
  <img id="cover-image-preview"><br><br>
  <label for="gallery-images">Galleria di immagini:</label><br>
  <input type="file" id="gallery-images" name="gallery-images" accept="image/*" on:change={previewGalleryImages} multiple><br><br>
  <div id="gallery-images-preview"></div><br><br>   
</div>

<div class="did1">
  <TextArea bind:value={form.didascalia}
    rows={5}
    labelText="Didascalia:"
    placeholder="Completare il campo..."
  />
</div>

<div class='lingua'>
  <Select labelText="Lingua didascalia:" on:change={(e) => form.lingua = e.target.value}>

    <SelectItem value="" text=" -- SELEZIONARE -- " />
    <SelectItem value="IT" text=" Italiano " />
    <SelectItem value="EN" text=" Inglese " />
  </Select>
</div>

<br>
<div class="did2">
  <TextArea bind:value={form.denominazionestorica}
    rows={5}
    labelText="Denominazione storica:"
    placeholder="Completare il campo..."
  />
</div>

<div>
  <button text='prova' on:click={caricaArray}>prova</button>
</div>

