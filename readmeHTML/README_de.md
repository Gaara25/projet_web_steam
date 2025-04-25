# 📦 Symfony-Projekt - Steam-Profil-Reproduktion

---

## 🎯 Ziel
Erstellen Sie eine dynamische Website mit Symfony (PHP) und VueJS, um ein personalisiertes Steam-Benutzerprofil nachzubilden mit:
- Benutzerverwaltung (Benutzername, Avatar usw.) ✅
- Spiele und Spielstatistiken ✅
- Implementierung einer minimalen API für VueJS ❌
- Eine saubere und relationale Datenbankstruktur ✅

### 🎯 Sekundäres Ziel
- Verwaltung von Datumsangaben in der gewählten Sprache ✅
- Avatar-Upload ✅
- Ermöglichen, dass Benutzer die Sprache basierend auf ihren Vorlieben ändern können ✅
- Hinzufügen von Sicherheit, sodass nur der Administrator Zugriff auf CRUD-Operationen hat ✅

---

## 🚀 Installation

### 🛠️ Voraussetzungen

- PHP 8.1 oder höher
- Composer
- Symfony CLI
- MySQL 8.0 oder höher
- Node.js

### Klonen Sie das Repository:
  ```bash
  git clone https://github.com/Gaara25/projet_web_steam.git
  cd projet_web_steam
  ```

## 🤝 Beiträge
Beiträge sind willkommen! Um beizutragen:
  - Synchronisieren Sie Ihren Fork mit dem Haupt-Repository (`git pull origin main`).
  - Erstellen Sie einen Branch für Ihre Funktionalität (`git checkout -b feature/mein-feature`).
  - Committen Sie Ihre Änderungen (`git commit -m "Hinzufügen meiner Funktionalität"`).
  - Pushen Sie Ihren Branch (`git push origin feature/mein-feature`).

---

## 📸 Screenshots

### Startseite
![Startseite](../public/screenshot/screenshot-home.png)

### Benutzerprofil
![Benutzerprofil](../public/screenshot/screenshot-profile.png)

### CRUD im Admin-Modus <!-- Das Passwort in meinem Dump ist "admin" und die E-Mail lautet "admin@gmail.com". -->
![CRUD-Admin-Oberfläche](../public/screenshot/screenshot-admin.png)

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
- Diese Abhängigkeiten werden für Übersetzungen und Datumsformatierungen benötigt:
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

- Diese Abhängigkeit wird verwendet, um eine minimale API einzurichten, die VueJS die Kommunikation mit dem Symfony-Backend ermöglicht:
  ```bash
  composer require api
  ```

- Diese Abhängigkeit wird verwendet, um Markdown-Text in HTML umzuwandeln:
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

- Befehl zum Erstellen eines Listeners, um `_locale` zu ändern, damit die Sprache basierend auf den Benutzervorlieben geändert werden kann:
  ```bash
  php bin/console make:listener LocaleSubscriber
      1. KernelEvents::REQUEST
  ```

---

## 🧱 Symfony-Projektstruktur

### Datenbankkonfiguration
In der Datei `.env.local` (zu erstellen):
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
- `avatarFile` (File, Vich\UploadableField)
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

---