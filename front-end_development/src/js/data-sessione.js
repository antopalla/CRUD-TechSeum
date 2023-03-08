// Variabili globali per la gestione della sessione dell'utente
import { writable } from 'svelte/store'
export let loggedIn = writable(false)
export let current_User = writable(null)