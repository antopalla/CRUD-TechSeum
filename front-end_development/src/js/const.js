export let url_path = 'localhost:3000'

// Variabili del form per creazione reperto tramite API
export const form = {
    // TABELLA REPERTINUOVA
    // codassoluto: "",
    datacatalogazione: "",
    nome: "",
    sezione: "",
    codrelativo: "",
    definizione: "",
    denominazionestorica: "",
    descrizione: "",
    modouso: "",
    annoiniziouso: "",
    annofineuso: "",
    scopo: "",
    stato: "",
    osservazioni: "",

    // TABELLA HAFATTO
    codautore: "",

    // TABELLA DIDASCALIE
    lingua: "",
    didascalia: "",

    // TABELLA COMPOSTODA
    codmateriale: [],

    // TABELLA MISURE
    tipomisura: [],
    valore: [],

    // TABELLA PARTI 
    nparte: "",
    nomeparte: "",

    // TABELLA ACQUISIZIONI
    codacquisizione: "",
    tipoacquisizione: "",
    dasoggetto: "",
    quantita: "",

    // TABELLA MEDIA
    nmedia: [],
    tipo: [],
    link: [],
    fonte: []
};