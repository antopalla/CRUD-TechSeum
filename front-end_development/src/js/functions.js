// FUNZIONI 
import { current_User } from "./data-sessione.js";
import { url_path } from "./const.js"
import { form } from "./const.js";
import { form_modifica } from "./const.js";

// Ottenere data del momento nel formato sql
export function getCurrentDateTime() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const formattedDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    return formattedDateTime;
}

// Assegnare valori alla costante del form modifica
export function assegnaValori(data) {
    form_modifica.codassoluto = data.id
    form_modifica.datacatalogazione = data.datacatalogazione
    form_modifica.nome = data.nome
    form_modifica.sezione = data.sezione
    form_modifica.codrelativo = data.codrelativo
    form_modifica.definizione = data.definizione
    form_modifica.denominazionestorica = data.denominazionestorica
    form_modifica.descrizione = data.descrizione
    form_modifica.modouso = data.modouso
    form_modifica.annoiniziouso = data.annoiniziouso
    form_modifica.annofineuso = data.annofineuso
    form_modifica.scopo = data.scopo
    form_modifica.stato = data.stato
    form_modifica.osservazioni = data.osservazioni

    form_modifica.codautore = data.codautore

    form_modifica.lingua = data.lingua
    form_modifica.didascalia = data.didascalia

    form_modifica.codmateriale = data.codmateriale
    
    form_modifica.tipomisura = data.tipomisura
    form_modifica.valore = data.valore

    form_modifica.nparte = data.nparte
    form_modifica.nomeparte = data.nomeparte

    form_modifica.codacquisizione = data.codacquisizione
    form_modifica.tipoacquisizione = data.tipoacquisizione
    form_modifica.dasoggetto = data.dasoggetto
    form_modifica.quantita = data.quantita

    form_modifica.nmedia = data.nmedia
    form_modifica.tipo = data.tipo
    form_modifica.link = data.link
    form_modifica.fonte = data.fonte
}

export function resetForm() {
    form.datacatalogazione = ""
    form.nome = ""
    form.sezione = ""
    form.codrelativo = ""
    form.definizione = ""
    form.denominazionestorica = ""
    form.descrizione = ""
    form.modouso = ""
    form.annoiniziouso = ""
    form.annofineuso = ""
    form.scopo = ""
    form.stato = ""
    form.osservazioni = ""

    form.codautore = ""

    form.lingua = ""
    form.didascalia = ""

    form.codmateriale = []
    
    form.tipomisura = []
    form.valore = []

    form.nparte = []
    form.nomeparte = []

    form.codacquisizione = 1
    form.tipoacquisizione = ""
    form.dasoggetto = ""
    form.quantita = ""

    form.nmedia = []
    form.tipo = []
    form.link = []
    form.fonte = []
}

export function resetFormModifica() {
    form_modifica.codassoluto = ""
    form_modifica.datacatalogazione = ""
    form_modifica.nome = ""
    form_modifica.sezione = ""
    form_modifica.codrelativo = ""
    form_modifica.definizione = ""
    form_modifica.denominazionestorica = ""
    form_modifica.descrizione = ""
    form_modifica.modouso = ""
    form_modifica.annoiniziouso = ""
    form_modifica.annofineuso = ""
    form_modifica.scopo = ""
    form_modifica.stato = ""
    form_modifica.osservazioni = ""

    form_modifica.codautore = ""

    form_modifica.lingua = ""
    form_modifica.didascalia = ""

    form_modifica.codmateriale = []
    
    form_modifica.tipomisura = []
    form_modifica.valore = []

    form_modifica.nparte = []
    form_modifica.nomeparte = []

    form_modifica.codacquisizione = 1
    form_modifica.tipoacquisizione = ""
    form_modifica.dasoggetto = ""
    form_modifica.quantita = ""

    form_modifica.nmedia = []
    form_modifica.tipo = []
    form_modifica.link = []
    form_modifica.fonte = []
}

// Funzione per l'upload di un file/immagine
export async function handleFileUpload (file, sezione, codrelativo, numero) {
    const formData = new FormData();
    formData.append('file', file);
    formData.append('sezione', sezione);
    formData.append('codrelativo', codrelativo);
    formData.append('numero', numero);

    const res = await fetch(url_path + '/back-end_development/immagine/upload_immagine.php', {
        method: 'post',
        body: formData
    });

    const data = await res.text();

    if (data["status"] == 0) {
        alert(data["data"]);
        return;
    }
    else {
        
    }
}

// Funzione per la rimozione di un file/immagine
export async function handleFileDelete (path) {
    const res = await fetch(url_path + '/back-end_development/immagine/delete_immagine.php?path='+path)

    const data = await res.json();

    if (data["status"] == 0) {
        //alert(data["data"]);
        //return;
    }
    else {
        
    }
}

// Funzione per il get di un URL contenente un oggetto che contiene il file fetchato dall'API
export async function fetchFile(path) {
    const response = await fetch(url_path + '/back-end_development/immagine/get_immagine.php?path='+path);

    try {
        const blob = await response.blob();
        const url = URL.createObjectURL(blob);

        return url
    }
    catch (error) {
        console.log("Non funziona il blob.")
    }
}

// Funzione per il get di un blob di un file fetchato dall'API
export async function fetchFileBlob(path) {
    const response = await fetch(url_path + '/back-end_development/immagine/get_immagine.php?path='+path);

    try {
        const blob = await response.blob();

        return blob
    }
    catch (error) {
        console.log("Non funziona il blob.")
    }
}

// Funzione per il check della password durante il login
export const login = async (username, password) => {
    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);
    const res = await fetch(url_path + '/back-end_development/check_login.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();

    if (data["status"] == 0) {
        alert('Credenziali non corrette!');
        return;
    }
    else {
        current_User.set(data["data"][0])
    }
}

// Funzione per la creazione di un utente
export const creaUtente = async (nome, cognome, amministratore, username, password) => {
    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('cognome', cognome);
    formData.append('amministratore', amministratore);
    formData.append('username', username);
    formData.append('password', password);
    const res = await fetch(url_path + '/back-end_development/utente/create_utente.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();

    if (data["status"] == 0) {
        alert('Errore nella creazione dell\'utente!');
        return;
    }
    else {
        alert('Utente aggiunto al database!');
    }
}

// Funzione per la modifica dell'utente
export const modificaUtente = async (nome, cognome, amministratore, username, codutente) => {
    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('cognome', cognome);
    formData.append('amministratore', amministratore);
    formData.append('username', username);
    formData.append('codutente',codutente)
    const res = await fetch(url_path + '/back-end_development/utente/update_utente.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();

    if (data["status"] == 0) {
        alert('Errore nella modifica dell\'utente!');
        return;
    }
    else {
        alert('Utente aggiornato!');
    }
}

export const modificaPasswordUtente = async (password, codutente) => {
    const formData = new FormData();
    formData.append('password', password);
    formData.append('codutente', codutente);
    const res = await fetch(url_path + '/back-end_development/utente/update_utente_password.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();

    if (data["status"] == 0) {
        alert('Errore nella modifica della password dell\'utente!');
        return;
    }
    else {
        alert('Password aggiornata!');
    }
}

// Funzione per la creazione di un reperto
export const creaReperto = async (jsonBody) => {
    
    const res = await fetch(url_path + '/back-end_development/reperto/create_reperto.php', {
        method: 'post',
        body: jsonBody
    });
    const data = await res.json();

    if (data["status"] == 0) {
        alert('Errore nella creazione del reperto!');
        return;
    }
    else {
        alert('Reperto aggiunto al database!');
    }
}

// Funzione per la modifica di un reperto
export const modificaReperto = async (jsonBody) => {
    
    const res = await fetch(url_path + '/back-end_development/reperto/update_reperto.php', {
        method: 'post',
        body: jsonBody
    });
    const data = await res.json();

    if (data["status"] == 0) {
        alert('Errore nella modifica del reperto!');
        return;
    }
    else {
        alert('Reperto modificato!');
    }
}

// Funzione per la creazione di un autore
export const creaAutore = async (nome, Adn, Adf) => {
    const formData = new FormData();
    formData.append('nomeautore', nome);
    formData.append('annonascita', Adn);
    formData.append('annofine', Adf);
    const res = await fetch(url_path + '/back-end_development/autore/create_autore.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();

    if (data["status"] == 0) {
        alert('Errore nella creazione dell\'Autore!');
        return;
    }
    else {
        alert('Autore aggiunto al database!');
    }
}

// Funzione per la modifica di un autore
export const modificaAutore = async (nome, Adn, Adf,id) => {
    const formData = new FormData();
    formData.append('nomeautore', nome);
    formData.append('annonascita', Adn);
    formData.append('annofine', Adf);
    formData.append('codautore',id);
    const res = await fetch(url_path + '/back-end_development/autore/update_autore.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();

    if (data["status"] == 0) {
        alert('Errore nella modifica dell\'Autore!');
        return;
    }
    else {
        alert('Autore modificato!');
    }
}

// Funzione per la creazione di un materiale
export const creaMateriale = async (nome) => {
    const formData = new FormData();
    formData.append('nomemateriale', nome);
    const res = await fetch(url_path + '/back-end_development/materiale/create_materiale.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();

    if (data["status"] == 0) {
        alert('Errore nella creazione del materiale!');
        return;
    }
    else {
        alert('Materiale aggiunto al database!');
    }
}

// Funzione per la modifica di un materiale
export const modificaMateriale = async (nome,id) => {
    const formData = new FormData();
    formData.append('nomemateriale', nome);
    formData.append('codmateriale',id);
    const res = await fetch(url_path + '/back-end_development/materiale/update_materiale.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();

    if (data["status"] == 0) {
        alert('Errore nella modifica del materiale!');
        return;
    }
    else {
        alert('Materiale modificato!');
    }
}

// Funzione per la creazione di una misura
export const creaMisura = async (tipomisura, nomemisura, unitadimisura) => {
    const formData = new FormData();
    formData.append('tipomisura', tipomisura);
    formData.append('nomemisura', nomemisura);
    formData.append('unitadimisura', unitadimisura);
    const res = await fetch(url_path + '/back-end_development/misura/create_misura.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();

    if (data["status"] == 0) {
        alert('Errore nella creazione della misura!');
        return;
    }
    else {
        alert('Misura aggiunta al database!');
    }
}

// Funzione per la modifica di un materiale
export const modificaMisura = async (tipomisura, nomemisura, unitadimisura) => {
    const formData = new FormData();
    formData.append('tipomisura', tipomisura);
    formData.append('nomemisura', nomemisura);
    formData.append('unitadimisura', unitadimisura);
    const res = await fetch(url_path + '/back-end_development/misura/update_misura.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();

    if (data["status"] == 0) {
        alert('Errore nella modifica della misura!');
        return;
    }
    else {
        alert('Misura modificata!');
    }
}
