function visualizzaReperto(codassoluto) {
    fetch("./serverSide/ricercaReperti.php?id=" + codassoluto)
    .then(response => {
        if(response.status != 200) {
            console.log("Richiesta fallita!");
            return;
        }

        response.json().then(jsonRep => {stamparep(jsonRep)});
    })
    .catch(err => {console.log("C'è stato un errore!")});
}

function stamparep(rep){
    //Inserimento informazioni principali
    document.getElementById("rep_sezione_codassoluto").innerHTML = ricavaSezione(rep.sezione).toUpperCase() + " - " + rep.codrelativo;
    document.getElementById("rep_titolo").innerHTML = rep.nome;
    if (rep.autori.length == 0)
        document.getElementById("rep_autore").innerHTML = "Sconosciuto";
    else
        document.getElementById("rep_autore").innerHTML = rep.autori.join(", ");
    //console.log(rep.didascalia.IT);
    //document.getElementById("rep_descrizione").innerHTML = rep.didascalia.IT;
    if (rep.didascalia.IT == undefined)
    {
        document.getElementById("rep_descrizione").innerHTML = '';
        //document.getElementById("rep_descrizione").innerHTML
        document.getElementById("titDidascalia").style.display = 'none';
        document.getElementById("separaDescr").style.display = 'none';
    }   
    else
    {
        document.getElementById("titDidascalia").style.display = 'block';
        document.getElementById("separaDescr").style.display = 'block';
        document.getElementById("rep_descrizione").innerHTML = rep.didascalia.IT;
    }
    if (rep.materiale.length == 0)
    {
        document.getElementById("rep_materiali").innerHTML = '';
        document.getElementById("titMateriali").style.display = 'none';
        document.getElementById("separaMat").style.display = 'none';
    }
    else
    {
        document.getElementById("titMateriali").style.display = 'block';
        document.getElementById("separaMat").style.display = 'block';
        document.getElementById("rep_materiali").innerHTML = camelCasizza(rep.materiale.join(", "));
    }
        
    var div_misure = document.getElementById("rep_dimensioni");
    var div_media = document.getElementById("container_immagini");

    div_misure.innerHTML = "";
    div_media.innerHTML = "";

    //Inserimento immagini
    if(parseInt(rep.nmedia) != 0){
        var divImg = document.getElementById("container_div_img");
        if(divImg.style.display != "block"){
            divImg.style.display = "block";
        }
        const numeroImmagini = parseInt(rep.nmedia);
        for(var nImmagine = 0; nImmagine < numeroImmagini; nImmagine++) {
            var img = document.createElement("img");
            img.src = "res/miniature/min_" + nomeFoto(rep.sezione, rep.codrelativo, nImmagine);
            div_media.appendChild(img);
            img.classList.add("mySlides");
        }
        mostraImmagine(0);

        //controllo del numero di immagini per determinare la presenza o no delle frecce di scorrimento
        var frecciaIndietro = document.getElementById("rep_but_left");
        var frecciaAvanti = document.getElementById("rep_but_right");
        if(parseInt(rep.nmedia) != 1){
            frecciaIndietro.style.display = "block";
            frecciaAvanti.style.display = "block";
        }
        else{
            frecciaIndietro.style.display = "none";
            frecciaAvanti.style.display = "none";
        }
    }
    else{
        var divImg = document.getElementById("container_div_img");
        if(divImg.style.display != "none"){
            divImg.style.display = "none";
        }
    }

    //Ottenimento misure
    Object.keys(rep.misura).forEach(m => {
        var divMisuraSingola = document.createElement("div");
        divMisuraSingola.classList.add("reperto_misura_singola");

        var valoreMisura = document.createElement("div");
        valoreMisura.innerText = rep.misura[m] + " " + addUnita(m);

        var iconaMisura = document.createElement("img");
        iconaMisura.src = "res/iconaMisura_" + m.replace("à", "a") + ".svg";

        var descrizioneMisura = document.createElement("div");
        descrizioneMisura.innerHTML = m;

        divMisuraSingola.appendChild(descrizioneMisura);
        divMisuraSingola.appendChild(iconaMisura);
        divMisuraSingola.appendChild(valoreMisura);
        div_misure.appendChild(divMisuraSingola);
    });

    //Visualizza pagina del reperto
    apriPaginaReperto();
}

//Aggiunge le unità di misura 
function addUnita(s) {
    switch(s.replace("à", "a")) {
        case "Capacita":
            return "mL";
        
        case "Altezza":
            return "cm";

        case "Lunghezza":
            return "cm";

        case "Profondita":
            return "cm";
        
        case "Peso":
            return "g";

        case "Memoria":
            return "kB";

        case "Resistenza":
            return "Ohm";

        case "Voltaggio":
            return "V";

        case "Amperaggio":
            return "A";

        case "Cavalli":
            return "Hp";

        case "Frequenza":
            return "Hz";

        case "Giri al minuto":
            return "rpm";

        case "Potenza":
            return "KW";
    }       
}

//Trasforma una stringa rendendo solo la prima lettera maiuscola
function camelCasizza(s) {
    s = s.toLowerCase()
    var c = s[0].toUpperCase();
    return c + s.substring(1, s.length);
}

function chiudiPaginaReperto() {
    document.getElementById("pagina_reperto_principale").style.top = "150vh";
    document.getElementById("chiudi_pagina_reperto").style.left = "150vw";
}

function apriPaginaReperto() {
    document.getElementById("pagina_reperto_principale").style.top = 0;
    document.getElementById("chiudi_pagina_reperto").style.left = 0;
}
