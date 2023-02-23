<script>
  import { Column, Grid, TextArea } from "carbon-components-svelte";
  /*import { FileUploaderDropContainer } from "carbon-components-svelte";
  import { ImageLoader, InlineLoading } from "carbon-components-svelte";*/
  import { Button } from "carbon-components-svelte";
  //import { ImageLoader } from "carbon-components-svelte";
  //import { FileUploaderDropContainer } from "carbon-components-svelte";

  function handleImageSelect(event) {
    const files = event.target.files;
    if (files) {
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = function(event) {
          const img = new Image();
          img.src = event.target.result;
          img.onload = function() {
            const previewContainer = document.querySelector('#preview-container');
            const imgPreview = document.createElement('img');
            imgPreview.src = img.src;
            imgPreview.classList.add('preview-image');
            previewContainer.appendChild(imgPreview);
          }
          selectedImages.push(event.target.result);
        };
        reader.readAsDataURL(file);
      }
    } else {
      selectedImages = [];
    }
}

</script>

<style>


  .prev2{
    margin: left;
      margin-top: 5%;
      margin-left: 10%;
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
    margin-top: 25%;
    margin-left: 15%;
    width: 300px;
    height: 300px;
    position: absolute;
  }
</style>

<div class='prove'>
    <div>
      <input type="file" multiple on:change={handleImageSelect} />
    </div>
    <Grid>
      <row>
          <Column>
              <div id="preview-container" class='prev2' style=object-fit:fill;
              width=100px;
              height=100px;
              border= solid> ></div>
          </Column>        
      </row>
    </Grid>
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


