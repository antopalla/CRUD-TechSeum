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
    console.log(data)

    if (data["status"] == 0) {
        alert('Errore nella creazione dell\'utente!');
        return;
    }
    else {
        alert('Utente aggiunto al database!');
    }
    /////////////////////////////////////////
    ////////////////////////////////////////
}

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
    console.log(data)

    if (data["status"] == 0) {
        alert('Errore nella modifica dell\'utente!');
        return;
    }
    else {
        alert('Utente modificato con successo!');
    }
    /////////////////////////////////////////
    ////////////////////////////////////////
}
