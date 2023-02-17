<script>
  import { TextArea } from "carbon-components-svelte";
  /*import { FileUploaderDropContainer } from "carbon-components-svelte";
  import { ImageLoader, InlineLoading } from "carbon-components-svelte";*/
  //import { FileUploader } from "carbon-components-svelte";
  import { Button } from "carbon-components-svelte";
  import { Theme } from "carbon-components-svelte";
  import { FileUploaderDropContainer } from "carbon-components-svelte";
</script>

<style>

/*
h1 { 
text-align: center;
color: black;
text-transform: uppercase;
padding: 1px;
font-family: 'Raleway', cursive;
font-weight: 100;
position: relative;
background: linear-gradient(to right, black, #eee, #E08000);
}
h1::before {
content: "";
position: absolute;
left: 50%;
top: -50px;
width: 600px;
margin-left: -300px;
margin-top: -220px;
height: 600px;
background: radial-gradient(50% 50%, ellipse closest-side, #444, #E08000);
z-index: -1;
}
h1 a {
background: #E08000;
display: block;
padding: 20px;
text-decoration: none;
letter-spacing: 30px;
color: black;
}
*/
  .did1{
      float: left;
      margin-top: 5%;
      margin-left: 25%;
      width: 200px;
      position: absolute;
      
      
  }

  .did2{
      margin: left;
      margin-top: 17%;
      margin-left: 25%;
      width: 200px;
      position: absolute;
  }
/*
  .img{
      margin: left;
      margin-top: 5%;
      margin-left: 1%;
      width: 300px;
      position: absolute;
  }

  .img1{
      margin: left;
      margin-top: 30%;
      margin-left: 1%;
      width: 300px;
      position: absolute;
  }

  .img2{
      margin: left;
      margin-top:30%;
      margin-left: 15%;
      width: 300px;
      position: absolute;
  }

  .img3{
      margin: left;
      margin-top:30%;
      margin-left: 29%;
      width: 300px;
      position: absolute;
  }
*/
  .button-17 {

    margin-left: 15%;
    margin-top:38%;
    align-items: center;
    appearance: none;
    background-color: #fff;
    border-radius: 24px;
    border-style: none;
    box-shadow: rgba(0, 0, 0, .2) 0 3px 5px -1px,rgba(0, 0, 0, .14) 0 6px 10px 0,rgba(0, 0, 0, .12) 0 1px 18px 0;
    box-sizing: border-box;
    color: #3c4043;
    cursor: pointer;
    display: inline-flex;
    fill: currentcolor;
    font-family: "Google Sans",Roboto,Arial,sans-serif;
    font-size: 14px;
    font-weight: 500;
    height: 48px;
    justify-content: center;
    letter-spacing: .25px;
    line-height: normal;
    max-width: 100%;
    overflow: visible;
    padding: 2px 24px;
    position: relative;
    text-align: center;
    text-transform: none;
    transition: box-shadow 280ms cubic-bezier(.4, 0, .2, 1),opacity 15ms linear 30ms,transform 270ms cubic-bezier(0, 0, .2, 1) 0ms;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    width: auto;
    will-change: transform,opacity;
    z-index: 0;
  }

  .button-17:hover {
    background: #F6F9FE;
    color: #174ea6;
  }

  .button-17:active {
    box-shadow: 0 4px 4px 0 rgb(60 64 67 / 30%), 0 8px 12px 6px rgb(60 64 67 / 15%);
    outline: none;
  }

  .button-17:focus {
    outline: none;
    border: 2px solid #4285f4;
  }

  .button-17:not(:disabled) {
    box-shadow: rgba(60, 64, 67, .3) 0 1px 3px 0, rgba(60, 64, 67, .15) 0 4px 8px 3px;
  }

  .button-17:not(:disabled):hover {
    box-shadow: rgba(60, 64, 67, .3) 0 2px 3px 0, rgba(60, 64, 67, .15) 0 6px 10px 4px;
  }

  .button-17:not(:disabled):focus {
    box-shadow: rgba(60, 64, 67, .3) 0 1px 3px 0, rgba(60, 64, 67, .15) 0 4px 8px 3px;
  }

  .button-17:not(:disabled):active {
    box-shadow: rgba(60, 64, 67, .3) 0 4px 4px 0, rgba(60, 64, 67, .15) 0 8px 12px 6px;
  }

  .button-17:disabled {
    box-shadow: rgba(60, 64, 67, .3) 0 1px 3px 0, rgba(60, 64, 67, .15) 0 4px 8px 3px;
  }
  


</style>

<!--<h1><a href="#0">Tech-Seum</a></h1>-->

<div class="mode">
  <Theme
  render="toggle"
  toggle={{
  themes: ["g10", "g80"],
  labelA: "Enable dark mode",
  labelB: "Enable dark mode",
  hideLabel: true,
  size: "sm",
}}
/>
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

<!--
<div class="imm">
<FileUploaderDropContainer
multiple
labelText="Seleziona immagine"
validateFiles={(files) => {
  return files.filter((file) => file.size < 1_024);
}}
on:change={(e) => {
  console.log("files", e.detail);
}}
/>
</div>

<div class="imm2">
<ImageLoader
src="imm"
/>
</div>-->

<!--
<div class="img">
  <FileUploader
    multiple
    kind="ghost"è
    labelTitle="Upload files"
    buttonLabel="Add files"
    accept={[".png", ".jpg", ".jpeg"]}
    status="complete"
  />
</div>

<div class="img1">
  <FileUploader
    multiple
    kind="ghost"
    labelTitle="Upload files"
    buttonLabel="Add files"
    accept={[".png", ".jpg", ".jpeg"]}
    status="complete"
  />
</div>

<div class="img2">
  <FileUploader
    multiple
    kind="ghost"
    labelTitle="Upload files"
    buttonLabel="Add files"
    accept={[".png", ".jpg", ".jpeg"]}
    status="complete"
  />
</div>

<div class="img3">
  <FileUploader
    multiple
    kind="ghost"
    labelTitle="Upload files"
    buttonLabel="Add files"
    accept={[".png", ".jpg", ".jpeg"]}
    status="complete"
  />
</div>
-->

<div class="button-17">
  <Button kind="ghost">Aggiungi</Button>
</div>

<FileUploaderDropContainer
multiple
labelText="Drag and drop files here or click to upload"
validateFiles={(files) => {
  return files.filter((file) => file.size < 1_024);
}}
on:change={(e) => {
  console.log("files", e.detail);
}}
/>

<!-- <ImageLoader
ratio="16x9"
src=files/> -->
