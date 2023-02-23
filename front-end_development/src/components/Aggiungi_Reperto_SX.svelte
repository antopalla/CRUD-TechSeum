<script>
  import { Column, Grid, TextArea } from "carbon-components-svelte";
  import { Button } from "carbon-components-svelte";


  function previewCoverImage(event) {
			var reader = new FileReader();
			reader.onload = function() {
				var output = document.getElementById('cover-image-preview');
				output.src = reader.result;
        output.style.height='200px'
			}
			reader.readAsDataURL(event.target.files[0]);
		}

		function previewGalleryImages(event) {
			var previewContainer = document.getElementById('gallery-images-preview');
			previewContainer.innerHTML = '';

			var files = event.target.files;
			for (var i = 0; i < files.length; i++) {
				var file = files[i];

				var reader = new FileReader();
				reader.onload = function() {
					var img = document.createElement('img');
					img.src = reader.result;
          img.style.height='100px'
					previewContainer.appendChild(img);
				}
				reader.readAsDataURL(file);
			}
		}

</script>

<style>

  .did1{
      float: left;
      margin-top: 5%;
      margin-left: 35%;
      width: 200px;
      position:absolute;
      
      
  }

  .did2{
      margin: right;
      margin-top: 17%;
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
  .button{
    margin: left;
    margin-top: 30%;
    margin-left: 35%;
    width: 300px;
    height: 300px;
    position: absolute;
  }


</style>

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
<TextArea 
  rows={5}
  labelText="Didascalia:"
  placeholder="Inserire didascalia reperto..."
/>
</div>

<div class="did2">
<TextArea 
  rows={5}
  labelText="Denominazione storica:"
  placeholder="Inserire denomnazione storica reperto..."
/>
</div>


<div class="button">
  <Button kind='ghost'>Aggiungi</Button>
</div>


