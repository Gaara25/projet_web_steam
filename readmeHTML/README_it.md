# 📦 Progetto Symfony - Riproduzione Profilo Steam

---

## 🎯 Obiettivo
Creare un sito web dinamico con Symfony (PHP) e VueJS che riproduca il profilo Steam di un utente personalizzato con:

### Symfony
- Gestione degli utenti (nickname, avatar…) ✅
- Giochi e statistiche di gioco ✅
- Implementazione di una API minima per VueJS ✅
- Una struttura di base pulita e relazionale ✅

#### 🎯 Obiettivo secondario
- Gestire le date visualizzate in lingua mantenuta ✅
- Upload dell’avatar ✅
- Possibilità di cambiare la lingua secondo la preferenza dell’utente ✅
- Aggiungere una sicurezza affinché solo l’admin possa vedere le CRUD ✅

### VueJS
- Utilizzo di diversi componenti ✅
- Utilizzo del router ✅
- Utilizzo di pinia ✅
- Una parte del sito utilizzerà l’API di Symfony per visualizzare dinamicamente i dati. ❌

---

## 🚀 Installazione

### 🛠️ Prerequisiti

- PHP 8.1 o superiore
- Composer
- Symfony CLI
- MySQL 8.0 o superiore
- Node.js

### Clonare il repository:
```bash
git clone https://github.com/Gaara25/projet_web_steam.git
cd projet_web_steam
```

## 🤝 Contributi
I contributi sono benvenuti! Per contribuire:
- Sincronizza il tuo fork con il repository principale (`git pull origin main`).
- Crea un branch per la tua funzionalità (`git checkout -b feature/my-feature`).
- Effettua il commit delle tue modifiche (`git commit -m "Aggiungi la mia funzionalità"`).
- Esegui il push del tuo branch (`git push origin feature/my-feature`).

---

## 📸 Screenshot

### Pagina Home
![Pagina Home](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-home.png?raw=true)

### Profilo Utente
![Profilo Utente](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-profile.png?raw=true)

### Interfaccia CRUD Admin 
<!-- La password nel mio dump è "admin" e l'email è "admin@gmail.com". -->
![Interfaccia CRUD Admin](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-admin.png?raw=true)

---

## 🏗️ Configurazione del Progetto Symfony

### Creazione del Progetto:
```bash
composer create-project symfony/skeleton progetto-steam
```

### Configurare Git:
```bash
git init
git add .
git commit -m "Commit iniziale"
git remote add origin https://github.com/Gaara25/projet_web_steam.git
git branch -M main
git push -u origin main
```

### Dipendenze utilizzate nel progetto:

#### Dipendenze di sviluppo:
```bash
composer require --dev profiler maker
```

#### Dipendenze di produzione:
  ```bash
  composer require twig form validator orm asset
  ```
- Queste dipendenze sono necessarie per la traduzione e la formattazione delle date:
  ```bash
  composer require symfony/translation
  composer require symfony/intl
  composer require twig/intl-extra
  ```

- Questa dipendenza è necessaria per la sicurezza:
  ```bash
  composer require symfony/security-bundle
  ```

- Questa dipendenza è utilizzata per il caricamento dei file:
  ```bash
  composer require vich/uploader-bundle
  ```

- Questa dipendenza è utilizzata per configurare una API minima che consente a VueJS di comunicare con il backend Symfony.
  ```bash
  composer require api
  ```

- Questa dipendenza è utilizzata per convertire il testo Markdown in HTML.
  ```bash
  composer require erusev/parsedown
  ```

### Alcuni comandi utili:
  
- Avviare il server locale:  
  ```bash
  symfony local:server:start
  ```

- Avviare MySQL su Linux:  
  ```bash
  sudo service mysql start
  ```
  oppure su Windows:  
  ```bash
  net start mySQL80
  ```

- Comandi per gestire la sicurezza e il login degli utenti:
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- Comando per creare un listener per modificare `_locale` per cambiare la lingua in base alla preferenza dell'utente:
  ```bash
  php bin/console make:listener LocaleSubscriber
      1. KernelEvents::REQUEST
  ```

---

## 🧱 Struttura del Progetto Symfony

### Configurazione del Database
Nel file `.env.local` (da creare):
```env
DATABASE_URL="mysql://user:pwd@localhost:3306/DBSteam?serverVersion=8"
```

Quindi, creare il database con il comando:
```bash
php bin/console doctrine:database:create
```

### Entità Create

#### 🧍‍♂️`User`
Comando per generare l'entità:  
```bash
php bin/console make:entity User
```
Campi:
- `id` (int)
- `username` (string)
- `email` (string)
- `avatar` (string, percorso file)
- `avatarFile` (File, Vich\UploadableField)
- `updatedAt` (datetime_immutable)
- `createdAt` (datetime_immutable)

#### 🎮`Game`
Comando per generare l'entità:  
```bash
php bin/console make:entity Game
```
Campi:
- `id` (int)
- `title` (string)
- `image` (string, percorso file o URL Steam)
- `developer` (string)
- `releaseDate` (date)

#### 📊`GameStat`
Comando per generare l'entità:  
```bash
php bin/console make:entity GameStat
```
Campi:
- `id` (int)
- `hoursPlayed` (int)
- `lastPlayed` (datetime_immutable)
- **Relazioni**:
  - `user` → ManyToOne a `User`
  - `game` → ManyToOne a `Game`

#### 💬`Comment`
Comando per generare l'entità:  
```bash
php bin/console make:entity Comment
```
Campi:
- `id` (int)
- `content` (text)
- `createdAt` (datetime_immutable)
- **Relazioni**:
  - `user` → ManyToOne a `User`

#### 🔒`UserAuthenticator`
Comando per generare l'entità:  
```bash
php bin/console make:user
```
Campi:
- `id` (int)
- `email` (string)
- `roles` (array)
- `password` (string)

---

### Generazione ed Esecuzione delle Migrazioni
- Generare le migrazioni:  
  ```bash
  php bin/console make:migration
  ```
- Eseguire le migrazioni:  
  ```bash
  php bin/console doctrine:migrations:migrate
  ```

---

### Generazione CRUD
Per ogni entità, ho generato le operazioni CRUD con i seguenti comandi:
```bash
php bin/console make:crud User
php bin/console make:crud Game
php bin/console make:crud GameStat
php bin/console make:crud Comment
```

---

## 🏗️ Configurazione del progetto VueJS

- Questa dipendenza è necessaria per garantire la compatibilità tra i moduli PHP e JavaScript di questo progetto.
  ```bash
  composer require symfony/webpack-encore-bundle
  ```

- Installazione delle dipendenze necessarie.
  ```bash
  npm install vue-router@4 pinia axios react react-dom prop-types vue-loader@^17.0.0
  ```

---

## 🌱 Eco-design del progetto

### Audit RGAA (Référentiel Général d’Amélioration de l’Accessibilité)
È stato condotto un audit per verificare la conformità del progetto al RGAA:
- **Struttura semantica**: Uso appropriato dei tag HTML (`header`, `nav`, `main`, `footer`, ecc.) per garantire una navigazione accessibile.
- **Contrasti**: I colori utilizzati rispettano i rapporti di contrasto raccomandati per assicurare la leggibilità dei contenuti.
- **Navigazione da tastiera**: Tutte le funzionalità principali sono accessibili tramite tastiera.
- **Alternative testuali**: Le immagini dispongono di attributi `alt` pertinenti.
- **Form**: I campi dei form sono correttamente etichettati e accessibili.

### Audit RGESN (Référentiel Général d’Écoconception des Services Numériques)
L’audit RGESN ha permesso di identificare e applicare diverse buone pratiche:
- **Lazy loading**: Implementazione del caricamento differito delle immagini per ridurre l’impatto ambientale durante il caricamento delle pagine.
- **Minimizzazione delle dipendenze**: Solo le librerie necessarie sono installate sia lato frontend che backend.
- **Gestione della cache**: Utilizzo della cache del browser per limitare le richieste inutili al server.
- **API ottimizzata**: Gli endpoint esposti da Symfony restituiscono solo i dati necessari alla visualizzazione, limitando così il volume di dati scambiati.

### Azioni di eco-design implementate
- **Eliminazione delle risorse inutilizzate**: Pulizia regolare del codice e rimozione delle dipendenze non utilizzate.
- **Documentazione**: Sensibilizzazione all’eco-design nella documentazione del progetto per incoraggiare futuri contributi responsabili.

Queste azioni contribuiscono a rendere il progetto più accessibile, performante e rispettoso dell’ambiente digitale.
