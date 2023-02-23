<script>
    import Modifica_dx from './Aggiungi_Reperto_DX.svelte';
    import Modifica_sx from './Aggiungi_Reperto_SX.svelte';
    import Header from "./Header.svelte";
</script>

<div class = 'header'>
    <Header />
  </div>

<div style="width: 80%; float: right">
    <Modifica_dx />
</div>

<div style="width: 50%;">
    <Modifica_sx />
</div>