function rilevaInvio(event) //se si preme invio viene avviata la ricerca
{
    //console.log("akkitemmu");
    var cod = event.which || event.keyCode; //unicode carattere premuto
    if (cod == 13) //13 = invio
        cercaRepertiPerParolaChiave(document.getElementById('keyword').value);
}

/* qui potrebbero anche essere aggiunte le funzioni per l'implementazione del tasto indietro */