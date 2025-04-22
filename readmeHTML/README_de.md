# 📦 Symfony-Projekt - Steam-Profil-Reproduktion

---

## 🎯 Ziel
Erstellen Sie eine dynamische Website mit Symfony (PHP) und VueJS, um ein personalisiertes Steam-Benutzerprofil zu reproduzieren mit:
- Benutzerverwaltung (Benutzername, Avatar usw.) ✅
- Spiele und Spielstatistiken ✅
- Implementierung einer minimalen API für VueJS ❌
- Eine saubere und relationale Basisstruktur ✅

- Verwalten von angezeigten Daten in der gewählten Sprache ✅
- Avatar-Upload ✅
- Ermöglichen, dass Benutzer die Sprache basierend auf ihren Vorlieben ändern können ✅
- Hinzufügen von Sicherheit, sodass nur der Administrator Zugriff auf CRUD-Operationen hat ✅

---

## 🏗️ Einrichtung des Symfony-Projekts

### Projekterstellung:
```bash
composer create-project symfony/skeleton projekt-steam
```

### Git konfigurieren:
```bash
git init
git add .
git commit -m "Initialer Commit"
git remote add origin https://github.com/Gaara25/projet_web_steam.git
git branch -M main
git push -u origin main
```

### Im Projekt verwendete Abhängigkeiten:

#### Entwicklungsabhängigkeiten:
```bash
composer require --dev profiler maker
```

#### Produktionsabhängigkeiten:
```bash
composer require twig form validator orm asset
```
- Diese Abhängigkeiten werden für Übersetzungen und Datumsformatierung benötigt:
```bash
composer require symfony/translation
composer require symfony/intl
composer require twig/intl-extra
```

- Diese Abhängigkeit wird für Sicherheit benötigt:
```bash
composer require symfony/security-bundle
```

- Diese Abhängigkeit wird für Datei-Uploads verwendet:
```bash
composer require vich/uploader-bundle
```
- Diese Abhängigkeit wird benötigt, um eine minimale API einzurichten, die VueJS die Kommunikation mit dem Symfony-Backend ermöglicht.
  ```bash
  composer require api
  ```

- Diese Abhängigkeit wird verwendet, um Markdown-Text in HTML umzuwandeln.
  ```bash
  composer require erusev/parsedown
  ```

### Einige nützliche Befehle:
  
- Lokalen Server starten:  
  ```bash
  symfony local:server:start
  ```

- MySQL unter Linux starten:  
  ```bash
  sudo service mysql start
  ```
  oder unter Windows:  
  ```bash
  net start mySQL80
  ```
- Befehle zur Verwaltung von Sicherheit und Benutzeranmeldungen:
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- Befehl zum Erstellen eines Listeners, um `_locale` zu ändern und die Sprache basierend auf Benutzerpräferenzen zu ändern:
  ```bash
  php bin/console make:listener
  ```

---

## 🧱 Symfony-Projektstruktur

### Datenbankkonfiguration
In der `.env.local` Datei (zu erstellen):
```env
DATABASE_URL="mysql://user:pwd@localhost:3306/DBSteam?serverVersion=8"
```

Dann die Datenbank mit folgendem Befehl erstellen:
```bash
php bin/console doctrine:database:create
```

### Erstellte Entitäten

#### 🧍‍♂️`User`
Befehl zum Generieren der Entität:  
```bash
php bin/console make:entity User
```
Felder:
- `id` (int)
- `username` (string)
- `email` (string)
- `avatar` (string, Dateipfad)
- `avatarFile` (Datei, Vich\UploadableField)
- `updatedAt` (datetime_immutable)
- `createdAt` (datetime_immutable)

#### 🎮`Game`
Befehl zum Generieren der Entität:  
```bash
php bin/console make:entity Game
```
Felder:
- `id` (int)
- `title` (string)
- `image` (string, Dateipfad oder Steam-URL)
- `developer` (string)
- `releaseDate` (date)

#### 📊`GameStat`
Befehl zum Generieren der Entität:  
```bash
php bin/console make:entity GameStat
```
Felder:
- `id` (int)
- `hoursPlayed` (int)
- `lastPlayed` (datetime_immutable)
- **Beziehungen**:
  - `user` → ManyToOne zu `User`
  - `game` → ManyToOne zu `Game`

#### 💬`Comment`
Befehl zum Generieren der Entität:  
```bash
php bin/console make:entity Comment
```
Felder:
- `id` (int)
- `content` (text)
- `createdAt` (datetime_immutable)
- **Beziehungen**:
  - `user` → ManyToOne zu `User`

#### 🔒`UserAuthenticator`
Befehl zum Generieren der Entität:  
```bash
php bin/console make:user
```
Felder:
- `id` (int)
- `email` (string)
- `roles` (array)
- `password` (string)

---

### Generieren und Ausführen von Migrationen
- Migrationen generieren:  
  ```bash
  php bin/console make:migration
  ```
- Migrationen ausführen:  
  ```bash
  php bin/console doctrine:migrations:migrate
  ```

---

### Generieren von CRUD
Für jede Entität habe ich CRUD-Operationen mit den folgenden Befehlen generiert:
```bash
php bin/console make:crud User
php bin/console make:crud Game
php bin/console make:crud GameStat
php bin/console make:crud Comment
```

#### 🔄 Änderungen

##### Aktualisierte `show`-Funktion im `GameController`

Die `show`-Funktion wurde aktualisiert, um die Details eines bestimmten Spiels basierend auf seiner `id` anzuzeigen.

##### Aktualisierte `buildForm`-Funktionen in `GameStatType` und `CommentType`

Die `buildForm`-Funktion wurde aktualisiert, um Formularfelder anzupassen, sodass benutzerfreundliche Labels oder Auswahlmöglichkeiten basierend auf den zugehörigen Entitätsdaten angezeigt werden, wie z. B. der `Name` einer Person oder der `Titel` eines Spiels.

##### Aktualisierte `__construct`-Funktion in `Comment`

Die `__construct`-Funktion wurde aktualisiert, um das Feld `createdAt` automatisch mit dem aktuellen Datum und der aktuellen Uhrzeit zu initialisieren.

##### Aktualisierte `templates`

Die `format_date`-Änderungen wurden vorgenommen, um eine ordnungsgemäße Datumsformatierung sicherzustellen.

---