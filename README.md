# CRUD-TechSeum
Sistema CRUD per la gestione dei reperti del museo digitale dell'istituto tecnico "Luigi di Maggio" di San Giovanni Rotondo.

**Istruzioni per il deploy dell'app su un server utilizzando l'adapter nodeJS di SvelteKIT:**
1. **Clonare la repository da GitHub:**
```
git clone https://github.com/AntoSuper/CRUD-TechSeum.git
```
2. **Andare nella directory appena clonata:**
```
cd CRUD-TechSeum
```
3. **Modificare il file const.php inserendo le credenziali del vostro database (esempio importabile dalla directory _documents_: techseum.sql) e i path delle directory di salvataggio delle immagini:**
```
nano back-end_development/protected/const.php
```
5. **Spostare la cartella _back-end_development_ in modo tale che questa sia raggiungibile tramite porta :80 o :443, quindi all'interno della director /var/www/html del vostro server**
6. **Posizionarsi poi nella cartella _front-end_development_:**
```
cd front-end_development
```
7. **Digitare il comando seguente per installare le dipendenze del progetto:**
```
npm install
```
8. **Modificare l'ip d'accesso al back-end nel file const.js (variabile url_path).**
 - Esempio: se la cartella _back-end_development_ l'avete inserita in /var/www/html basterà inserire http://localhost
```
nano src/js/const.js
```
9. **Nella cartella _front-end_development_ eseguire il seguente comando per fare la build dell'app:**
```
npm run build
```
10. **Sempre nella stessa cartella, eseguire il comando seguente per installare pm2:**
```
npm i -g pm2
```
11. **Sempre nella stessa cartella, far partire l'app con nodeJS eseguendo il comando:**
```
pm2 start build/index.js
```
12. **Dal browser ora si può accedere al sito connettendo all'URL http://ipdelserver:3000**
  - Credenziali di accesso:
  ```
  Username: admin
  Password: admin123
  ```
14. **Se si riscontrano problemi, permettere le connessioni alla porta 3000 modificando le impostazione del firewall.**
 - Esempio con ufw:
```
ufw allow 3000
ufw reload
```
14. **In seguito si potrà eseguire un reverse proxy sull'URL del sito.**
 - Esempio con Caddy:
```
crud.techseum.it {
  root * /var/www/html/CRUD-TechSeum/front-end_development/build
  reverse_proxy * localhost:3000
}
```
