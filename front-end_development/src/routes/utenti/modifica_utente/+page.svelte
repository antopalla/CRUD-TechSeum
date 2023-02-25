<!-- QUESTA E' LA PAGINA DI MODIFICA UTENTE -->

<script>
    import ModificaUtente from '../../../components/Modifica_Utente.svelte'
    import { onMount } from 'svelte'
    import { current_User, loggedIn } from '../../../js/data-sessione.js'
	import { goto } from '$app/navigation';

    onMount(async() => {
        if ($current_User && $current_User["amministratore"] == 1 && $loggedIn == true) {
            
        }
        else {
            alert("Non hai i permessi per accedere a questa pagina! Contattare un amministratore.")
            goto("/")
        }
	})
</script>

<ModificaUtente />