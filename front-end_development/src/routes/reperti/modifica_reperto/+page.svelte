<!-- QUESTA E' LA PAGINA DI AGGIUNTA DEI REPERTI -->

<script>
    import ModificaReperto from '../../../components/Modifica_Reperto.svelte';
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

<ModificaReperto />
