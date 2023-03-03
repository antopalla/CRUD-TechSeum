<!-- QUESTA E' LA PAGINA PER CAMBIARE LA PROPRIA PASSWORD -->

<script>
    
    import ModificaPassword from '../../../components/Modifica_Password.svelte';
    import { onMount } from 'svelte';
    import {current_User, loggedIn} from '../../../js/data-sessione.js';
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

<ModificaPassword />

