# MIIDMApp
[App del MIIDM](https://databasereperti.altervista.org/)

Codice dell'applicativo (webapp) del Museo Informatico dell'Iiss Di Maggio.
La suddetta applicazione è una mobile PWA (Progressive Web App): ciò vuol dire che può essere "installata" attraverso il browser sul proprio smartphone. L'app non è ancora ottimizzata per l'utilizzo su desktop.

## Descrizione sintetica della struttura dell'app
Abbiamo cercato, per quanto possibile, di sviluppare la PWA seguendo il modello MVC (Model - View - Controller). Alcuni script JavaScript (controller) intercettano degli input da parte degli utenti e interrogano il server (model) per restituire le informazioni che poi vengono visualizzate nella view.
Il nucleo di tutta l'app è il file `index.php`. Al suo interno, infatti, le diverse pagine vengono renderizzate (tramite lo script `script\pageNavigation.js`) nel div `#pageRender` e i moduli (file HTML) delle varie sezioni dell'app vengono inclusi.
Per non appesantire troppo il caricamento iniziale dell'app, tutte le pagine "secondarie" sono caricate tramite AJAX dallo script (in modo asincrono, dunque), eccetto le componenti necessarie alla visualizzazione della shell (es. `navbar.html`, che sono incluse direttamente in `index.php`).

## Descrizione approfondita delle componenti
*Questa sezione ha lo scopo di approfondire il funzionamento di alcune pagine e come queste interagiscano tra loro. Tuttavia essa è inutile senza la documentazione costituita dai commenti, dal video tutorial e dai diagrammi nella cartella "docs".*
### Requisiti PWA
- Il file `manifest.json` descrive le caratteristiche della Progressive Web App affinchè possa essere installata tramite il browser del dispositivo.
### Script Javascript
- Il caricamento delle pagine in seguito al click sui collegamenti è gestito dallo script `page_navigation.js`, richiamato nella home.
- Lo script `elencoReperti.js` genera la lista di reperti in base alla categoria scelta dall'utente o alla parola chiave inserita. Una volta selezionato il reperto di cui si vogliono visualizzare le info:
- `reperto.js` inserisce tutti i dati relativi all'oggetto selezionato nella pagina `reperto.html`.
Le altre pagine sono perlopiù librerie necessarie alla scansione del QR Code.
**NB: La metodologia usata per la scansione QR viene attualmente supportata solo da Android e non da iOS (ovviamente!). È necessario trovare un'alternativa valida.**
### Script server (PHP)
- `base.php` contiene i parametri relativi alla configurazione del database.
- `ricercaReperti.php` riceve una richiesta GET per uno o più reperti (identificati dall'ID, da alcune parole chiave o da una sezione di riferimento) e restituisce una stringa JSON che rappresenta gli oggetti richiesti
- `segnalaUnBug.php` è il backend che permette di inviare una mail per la segnalazione di un bug all'indirizzo mail specificato in `base.php`, tramite la compilazione di un form.
### Elenco pagine e moduli HTML
- `bottom_navbar.html` è il codice della barra di navigazione inferiore, quella che contiene i due collegamenti principali a "Home" e "Cerca" e il pulsante per la scansione del codice QR. Contiene anche funzioni JavaScript per la gestione dello styling della barra inferiore.
- `elencoReperti.html` è la pagina nella quale vengono a loro volta renderizzate e inserite sia la pagina per la ricerca dei reperti che la lista dei risultati.
- `info.html` fa visualizzare informazioni sul museo.
- `navbar.html` contiene il codice della barra di navigazione superiore e quello del menu a comparsa laterale (sidebar) con i vari collegamenti.
- `navbar.html` è il modulo HTML nel quale viene renderizzata la schermata per la scansione del codice QR dei reperti.
- `reperto.html` contiene il codice della pagina HTML nella quale verranno inserite le informazioni relative a un singolo reperto.
- `segnalaUnBug.html` contiene il form (in comparsa dall'alto), dotato di protezione reCAPTCHA, per l'invio delle email.

## Installazione
Prima di poter rendere operativa la PWA, è necessario svolgere alcune operazioni:
- Modificare il file `serverSide/base.php` inserendo le credenziali corrette per l'accesso al database (nome utente, password, hostname e nome del database)
- Importare il file `databaseReperti.sql` nel proprio DBMS per avere con sé i dati dei reperti

## Ulteriori documenti e collegamenti
- Video tutorial e presentazione dell'app: Clicca [qui](https://drive.google.com/file/d/169M5yHPrrIfFpcWQDnKis5l-MhNmDXSO/view?usp=sharing) (non ho potuto caricarlo su GitHub per il limite di 25 MB sull'upload).
- [Bacheca Trello](https://trello.com/invite/b/4Vwokeyv/2a303385ee1b0b4d10f29edb61bb32ce/view-miidm-app) per la gestione Agile delle cose da fare.

## Contatti
Hai ancora qualche piccolo dubbio? Non c'hai capito na mazza? Contattami con una mail a [peppesteduto@gmail.com](mailto:peppesteduto@gmail.com)!
