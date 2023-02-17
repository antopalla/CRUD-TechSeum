<!-- QUESTA E' LA PAGINA DI LOGOUT -->

<script>
    import Logout from '../components/Login_Form.svelte';
    import { onMount } from 'svelte'
    import { current_User, loggedIn} from '../../js/data-sessione.js'
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

<Logout />
