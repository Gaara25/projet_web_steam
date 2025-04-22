# 📦 Progetto Symfony - Riproduzione Profilo Steam

---

## 🎯 Obiettivo
Creare un sito web dinamico utilizzando Symfony (PHP) e VueJS per replicare un profilo utente personalizzato di Steam con:
- Gestione utenti (nome utente, avatar, ecc.) ✅
- Giochi e statistiche di gioco ✅
- Implementazione di una API minima per VueJS ❌
- Una struttura di base pulita e relazionale ✅

- Gestione delle date visualizzate nella lingua mantenuta ✅
- Caricamento avatar ✅
- Consentire agli utenti di cambiare lingua in base alle loro preferenze ✅
- Aggiungere sicurezza in modo che solo l'amministratore possa accedere alle operazioni CRUD ✅

---

## 🏗️ Configurazione del Progetto Symfony

### Creazione del Progetto:
```bash
composer create-project symfony/skeleton projet-steam
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
- Comandi per gestire la sicurezza e i login degli utenti:
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- Comando per creare un listener per modificare `_locale` per cambiare la lingua in base alla preferenza dell'utente:
  ```bash
  php bin/console make:listener
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

#### 🔄 Modifiche

##### Funzione `show` aggiornata in `GameController`

La funzione `show` è stata aggiornata per visualizzare i dettagli di un gioco specifico in base al suo `id`.

##### Funzioni `buildForm` aggiornate in `GameStatType` e `CommentType`

La funzione `buildForm` è stata aggiornata per personalizzare i campi del modulo, consentendo la visualizzazione di scelte o etichette user-friendly basate sui dati dell'entità associata, come il `name` di una persona o il `title` di un gioco.

##### Funzione `__construct` aggiornata in `Comment`

La funzione `__construct` è stata aggiornata per inizializzare automaticamente il campo `createdAt` con la data e l'ora correnti.

##### Modificati i file `templates`

Le modifiche `format_date` sono state apportate per garantire una corretta formattazione delle date.

---