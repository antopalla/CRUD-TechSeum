<script>
  import { Column, Grid, TextArea } from "carbon-components-svelte";
  import { Button } from "carbon-components-svelte";


  function handleImageSelect(event) {
    const input = document.querySelector('#imgInput');
      const preview = document.querySelector('#preview');
      
      input.addEventListener('change', () => {
        preview.innerHTML = '';
        const files = input.files;
        for (let i = 0; i < files.length; i++) {
          const file = files[i];
          const reader = new FileReader();
          reader.addEventListener('load', () => {
            const img = document.createElement('img');
            img.src = reader.result;
            img.style.maxWidth = '100px';
            img.style.margin = '10px';
            preview.appendChild(img);
          });
          reader.readAsDataURL(file);
        }
      });
}

</script>

<style>


  .prev2{
    margin: left;
      margin-top: 5%;
      margin-left: 3%;
      grid-template-columns: repeat(auto-fill, minmax(0, 1fr));
      object-fit:fill;
      border: solid;
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
    margin-top: 30%;
    margin-left: 35%;
    width: 300px;
    height: 300px;
    position: absolute;
  }

</style>

<div class='prove'>
    <div>
      <input type="file" id='imgInput' multiple on:click={handleImageSelect}/>
    </div>

    <div id="preview" class='prev2'></div>      

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


