import { current_User } from "./data-sessione.js";
import { url_path } from "./const.js"

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

// Funzione per l'upload di un file/immagine
export async function handleFileUpload (file) {
    const formData = new FormData();
    formData.append('fileToUpload', file);

    const res = await fetch('http://' + url_path + '/back-end_development/immagine/upload_immagine.php', {
        method: 'post',
        body: formData
    });

    const data = await res.json();

    if (data["status"] == 0) {
        alert(data["data"]);
        return;
    }
    else {
        
    }
}

// Funzione per la rimozione di un file/immagine
export async function handleFileDelete (path) {
    const res = await fetch('http://' + url_path + '/back-end_development/immagine/delete_immagine.php?path='+path)

    const data = await res.json();

    if (data["status"] == 0) {
        //alert(data["data"]);
        //return;
    }
    else {
        
    }
}

// Funzione per il check della password durante il login
export const login = async (username, password) => {
    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);
    const res = await fetch('http://' + url_path + '/back-end_development/check_login.php', {
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
    const res = await fetch('http://' + url_path + '/back-end_development/utente/create_utente.php', {
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
export const modificaUtente = async (nome, cognome, amministratore, username, password,codutente) => {
    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('cognome', cognome);
    formData.append('amministratore', amministratore);
    formData.append('username', username);
    formData.append('password', password);
    formData.append('codutente',codutente)
    const res = await fetch('http://' + url_path + '/back-end_development/utente/update_utente.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();

    if (data["status"] == 0) {
        alert('Errore nella modifica dell\'utente!');
        return;
    }
    else {
        alert('Utente modificato con successo!');
    }
}

// Funzione per la creazione di un reperto
export const creaReperto = async (jsonBody) => {
    
    const res = await fetch('http://' + url_path + '/back-end_development/reperto/create_reperto.php', {
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
    
    const res = await fetch('http://' + url_path + '/back-end_development/reperto/update_reperto.php', {
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
    const res = await fetch('http://' + url_path + '/back-end_development/autore/create_autore.php', {
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
    const res = await fetch('http://' + url_path + '/back-end_development/autore/update_autore.php', {
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

export const creaMateriale = async (nome) => {
    console.log(nome);
    const formData = new FormData();
    formData.append('nomemateriale', nome);
    const res = await fetch('http://' + url_path + '/back-end_development/materiale/create_materiale.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();
    console.log(data)

    if (data["status"] == 0) {
        alert('Errore nella creazione del Materiale!');
        return;
    }
    else {
        alert('Materiale aggiunto al database!');
    }
}

export const modificaMateriale = async (nome,id) => {
    console.log(nome);
    console.log(id);
    const formData = new FormData();
    formData.append('nomemateriale', nome);
    formData.append('codmateriale',id);
    const res = await fetch('http://' + url_path + '/back-end_development/materiale/update_materiale.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();
    console.log(data)

    if (data["status"] == 0) {
        alert('Errore nella modifica del Materiale!');
        return;
    }
    else {
        alert('Materiale modificato!');
    }
}

export const eliminaMateriale = async (id) => {
    const formData = new FormData();
    formData.append('codmateriale',id);
    const res = await fetch('http://' + url_path + '/back-end_development/materiale/delete_materiale.php', {
        method: 'post',
        body: formData
    });
    const data = await res.json();
    console.log(data)

    if (data["status"] == 0) {
        alert('Errore nell\'eliminazione del Materiale!');
        return;
    }
    else {
        alert('Materiale eliminato!');
    }
}

