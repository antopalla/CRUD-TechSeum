<!-- QUESTA E' LA PAGINA DI AGGIUNTA E DI MODIFICA DEGLI AUTORI -->

<script>
    import AggiungiModificaAutore from '../../../components/Aggiungi_Modifica_Autore.svelte';
    import { onMount } from 'svelte'
    import { current_User, loggedIn} from '../../../js/data-sessione.js'
	import { goto } from '$app/navigation';

    onMount(async() => {
        if ($current_User && $loggedIn == true) {
            
        }
        else {
            alert("Non sei loggato!")
            goto("/")
        }
	})

</script>

<AggiungiModificaAutore />