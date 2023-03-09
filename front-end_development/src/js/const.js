// Variabile da modificare: url di accesso al back-end
export let url_path = 'http://'

// Variabili del form per creazione reperto tramite API
export const form = {
    // TABELLA REPERTINUOVA
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
    nparte: [],
    nomeparte: [],

    // TABELLA ACQUISIZIONI
    codacquisizione: 1,
    tipoacquisizione: "",
    dasoggetto: "",
    quantita: "",

    // TABELLA MEDIA
    nmedia: [],
    tipo: [],
    link: [],
    fonte: []
};

// Variabili del form per la modifica del reperto tramite API
export const form_modifica = {
    // TABELLA REPERTINUOVA
    codassoluto: "",
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
    nparte: [],
    nomeparte: [],

    // TABELLA ACQUISIZIONI
    codacquisizione: 1,
    tipoacquisizione: "",
    dasoggetto: "",
    quantita: "",

    // TABELLA MEDIA
    nmedia: [],
    tipo: [],
    link: [],
    fonte: []
};
