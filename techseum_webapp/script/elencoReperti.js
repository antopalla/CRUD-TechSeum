//Verifica se un'immagine e presente altrimenti da l'url di un immagine sostitutiva 
function ceckImg(url){
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', url, false);
    xhr.send();

    if(xhr.status == "200"){
        return url;
    }
    else{
        return "res/miniature/immagine_assente.png";
    }
}

function animaSelezione(sezione) {
    sezione.style.backgroundColor = "#f1c40e";
    cercaRepertiPerSezione(sezione.id);
}

function cercaRepertiPerParolaChiave(key) {
    if(key == '' || key == ' ') {
        alert("Inserisci una o più parole chiavi valide!");
        return;
    }
    costruisciListaReperti("./serverSide/ricercaReperti.php?keyword=" + key, key);
}

function cercaRepertiPerSezione(sez) {
    costruisciListaReperti("./serverSide/ricercaReperti.php?section=" + sez, ricavaSezione(sez));
}


function costruisciListaReperti(url, key) {
    fetch(url)
        .then(
            function(response) {
                if(response.status != 200) {
                    console.log("Richiesta rifiutata!");
                    return;
                }

                response.json()
                .then(reperti => {
                    var containerListaReperti = document.createElement("div");
                    containerListaReperti.id = "lista_reperti";
                    document.getElementById("page_render").innerHTML = "";
                    var intestazione = document.createElement("p");
                    intestazione.innerHTML = "Stai visualizzando i risultati di ricerca per: '<strong>" + key + "</strong>'";
                    intestazione.classList.add("intestazione");
                    document.getElementById("page_render").appendChild(intestazione);
                    document.getElementById("page_render").appendChild(containerListaReperti);
                    reperti.forEach(stampaReperto);
                    bothEmpty(); //Mette entrambe le icone della bottomBar vuote
                });
            }
        ).catch(function(err) {
            console.log("Qualcosa è andato storto!", err);
        });
}

//function stampaReperto(reperto, index) {
function stampaReperto(reperto) {
    //Crea article principale
    var rep = document.createElement("article");
    rep.classList.add("reperto");

    //Crea div container - grid
    var divcontainer = document.createElement("div");
    divcontainer.classList.add("informazioniReperto_gridcontainer");

    //Crea container per l'immagine
    var containerImg = document.createElement("div");
    containerImg.classList.add("imgReperto_container");
    var imgReperto = document.createElement("img");
    imgReperto.classList.add("imgReperto");
    imgReperto.src = ceckImg("res/miniature/min_" + nomeFoto(reperto.sezione, reperto.codrelativo, 0));////////////////////////////////////////////////
    containerImg.appendChild(imgReperto);

    //Crea titolo reperto
    var titoloReperto = document.createElement("p");
    titoloReperto.appendChild(document.createTextNode(reperto.nome));
    titoloReperto.classList.add("titoloReperto");

    //Crea informazioni data
    var infoData = document.createElement("div");
    infoData.classList.add("infoReperto");
    infoData.classList.add("infoDataReperto");
    var iconaDataContainer = document.createElement("div");
    iconaDataContainer.classList.add("iconaInfoRepertoContainer");
    var iconaData = document.createElement("img");
    iconaData.classList.add("iconaInfoReperto");
    iconaData.src = "res/calendar.png";
    iconaDataContainer.appendChild(iconaData);
    infoData.appendChild(iconaDataContainer);
    var informazioniData = document.createElement("div");
    var spanData1 = document.createElement("span");
    spanData1.appendChild(document.createTextNode("Data: "));
    var spanData2 = document.createElement("span");
    spanData2.appendChild(document.createTextNode(ricavaData(reperto.annoiniziouso)));
    informazioniData.appendChild(spanData1);
    informazioniData.appendChild(spanData2);
    infoData.appendChild(informazioniData);

    //Crea informazioni autore
    var infoAutore = document.createElement("div");
    infoAutore.classList.add("infoReperto");
    infoAutore.classList.add("infoAutoreReperto");
    var iconaAutoreContainer = document.createElement("div");
    iconaAutoreContainer.classList.add("iconaInfoRepertoContainer");
    var iconaAutore = document.createElement("img");
    iconaAutore.classList.add("iconaInfoReperto");
    iconaAutore.src = "res/tools.png";
    iconaAutoreContainer.appendChild(iconaAutore);
    infoAutore.appendChild(iconaAutoreContainer);
    var informazioniAutore = document.createElement("div");
    var spanAutore1 = document.createElement("span");
    spanAutore1.appendChild(document.createTextNode("Autore: "));
    var spanAutore2 = document.createElement("span");
    spanAutore2.appendChild(document.createTextNode(ricavaAutore(reperto.autori[0]))); //DA AGGIUSTARE
    informazioniAutore.appendChild(spanAutore1);
    informazioniAutore.appendChild(spanAutore2);
    infoAutore.appendChild(informazioniAutore);

    //Crea informazioni sezione
    var infoSezione = document.createElement("div");
    infoSezione.classList.add("infoReperto");
    infoSezione.classList.add("infoSezioneReperto");
    var iconaSezioneContainer = document.createElement("div");
    iconaSezioneContainer.classList.add("iconaInfoRepertoContainer");
    var iconaSezione = document.createElement("img");
    iconaSezione.classList.add("iconaInfoReperto");
    iconaSezione.src = "res/section.png";
    iconaSezioneContainer.appendChild(iconaSezione);
    infoSezione.appendChild(iconaSezioneContainer);
    var informazioniSezione = document.createElement("div");
    var spanSezione1 = document.createElement("span");
    spanSezione1.appendChild(document.createTextNode("Sezione: "));
    var spanSezione2 = document.createElement("span");
    spanSezione2.appendChild(document.createTextNode(ricavaSezione(reperto.sezione))); //DA AGGIUSTARE
    informazioniSezione.appendChild(spanSezione1);
    informazioniSezione.appendChild(spanSezione2);
    infoSezione.appendChild(informazioniSezione);

    //Vai a capo e crea bottone
    var bottone = document.createElement("button");
    bottone.classList.add("leggiDiPiu");
    bottone.name = reperto.codassoluto;
    bottone.appendChild(document.createTextNode("Leggi di più!"));
    bottone.addEventListener("click", function() {
        this.classList.add("bottoneCliccato");
        visualizzaReperto(this.name);
        setTimeout(function() {
            bottone.classList.remove("bottoneCliccato")
        }, 500);
    })

    divcontainer.appendChild(containerImg);
    divcontainer.appendChild(titoloReperto);
    divcontainer.appendChild(infoData);
    divcontainer.appendChild(infoAutore);
    divcontainer.appendChild(infoSezione);
    rep.appendChild(divcontainer);
    rep.appendChild(bottone);

    //Aggiungi tutto alla pagina
    document.getElementById("lista_reperti").appendChild(rep);
}

//A partire dalla sezione e dal codice, genera il nome della (prima) foto di un reperto
function nomeFoto(sezione, cod, nImmagine) {
    var nome = "";
    switch(sezione) {
        case 'E':
            nome = "ELE";
            break;
        case 'I':
            nome = "INF";
            break;
        case 'M':
            nome = "MCC";
            break;
        case 'F':
            nome = "FIS";
            break;
    }
    cod = "" + cod;
    cod = cod.padStart(3, '0');
    nome += "-" + cod + "." + nImmagine + ".jpg";
    return nome;
}

function ricavaSezione(sez) {
    switch(sez) {
        case 'E':
            return "Elettronica";
        case 'I':
            return "Informatica";
        case 'M':
            return "Meccanica";
        case 'S':
            return "Scienze";
    }
}

function ricavaData(data) {
    if(data == -1) {
        return "Sconosciuta";
    }
    return data;
}

function ricavaAutore(aut) {
    if (typeof aut === 'undefined') {
        return "Sconosciuto";
    }
    if(aut.length >= 11) { //Autore troppo lungo per entrare su una riga
        return aut.substring(0, 9) + "...";
    }
    return aut;
}

function Device_Type() {
    var Return_Device; 
    if(/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile|w3c|acs\-|alav|alca|amoi|audi|avan|benq|bird|blac|blaz|brew|cell|cldc|cmd\-|dang|doco|eric|hipt|inno|ipaq|java|jigs|kddi|keji|leno|lg\-c|lg\-d|lg\-g|lge\-|maui|maxo|midp|mits|mmef|mobi|mot\-|moto|mwbp|nec\-|newt|noki|palm|pana|pant|phil|play|port|prox|qwap|sage|sams|sany|sch\-|sec\-|send|seri|sgh\-|shar|sie\-|siem|smal|smar|sony|sph\-|symb|t\-mo|teli|tim\-|tosh|tsm\-|upg1|upsi|vk\-v|voda|wap\-|wapa|wapi|wapp|wapr|webc|winw|winw|xda|xda\-) /i.test(navigator.userAgent)) {
        if(/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i.test(navigator.userAgent)) {
            Return_Device = 'Tablet';
        }
        else {
            Return_Device = 'Mobile';
        }
    }
    else if(/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i.test(navigator.userAgent)) {
        Return_Device = 'Tablet';
    }
    else {
        Return_Device = 'Desktop';
    }

    return Return_Device;
}