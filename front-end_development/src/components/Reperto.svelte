<script>
    import {reperti} from '../js/data-reperti.js'
    import {Row, Column} from "carbon-components-svelte";
    export let reperto = {}

</script>

<style> 
input {
  width: 100%;
}
</style>

<div class='reperto'>
    <Row>
        <Column>{reperto.codassoluto}</Column>
        <Column><input type = "text" value={reperto.nome}></Column>
        <Column><input type = "text" value={reperto.sezione}></Column>
    </Row>
</div>