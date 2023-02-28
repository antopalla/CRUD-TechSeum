import {writable} from 'svelte/store'
export let theme = writable([]); // "white" | "g10" | "g80" | "g90" | "g100"
export let dark_mode_toggled = writable([]);
export let sideNavStyle = writable([]);
export let buttonStyle= writable([]);
export let bgColor = writable([]);
export let menuBgColor = writable([]);

