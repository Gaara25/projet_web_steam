# 📦 Symfony-projekt - Steam-profilreproduktion

---

## 🎯 Syfte
Skapa en dynamisk webbplats med Symfony (PHP) och VueJS för att replikera en personlig Steam-användarprofil med:
- Användarhantering (användarnamn, avatar, etc.) ✅
- Spel och spelstatistik ✅
- Implementering av ett minimalt API för VueJS ❌
- En ren och relationell databasstruktur ✅

### 🎯 Sekundärt syfte
- Hantera datum som visas på det valda språket ✅
- Avataruppladdning ✅
- Tillåta användare att ändra språk baserat på deras preferenser ✅
- Lägga till säkerhet så att endast administratören kan komma åt CRUD-operationer ✅

---

## 🚀 Installation

### 🛠️ Förutsättningar

- PHP 8.1 eller högre
- Composer
- Symfony CLI
- MySQL 8.0 eller högre
- Node.js

### Klona repositoryt:
```bash
git clone https://github.com/Gaara25/projet_web_steam.git
cd projet_web_steam
```

## 🤝 Bidrag
Bidrag är välkomna! För att bidra:
- Synkronisera din fork med huvudrepositoryt (`git pull origin main`).
- Skapa en gren för din funktion (`git checkout -b feature/my-feature`).
- Begå dina ändringar (`git commit -m "Add my feature"`).
- Skjut upp din gren (`git push origin feature/my-feature`).

---

## 📸 Skärmdumpar

### Startsida
![Startsida](../public/screenshot/screenshot-home.png)

### Användarprofil
![Användarprofil](../public/screenshot/screenshot-profile.png)

### Admin CRUD-gränssnitt <!-- Lösenordet i min dump är "admin" och e-posten är "admin@gmail.com". -->
![Admin CRUD-gränssnitt](../public/screenshot/screenshot-admin.png)

---

## 🏗️ Installera Symfony-projektet

### Skapa projektet:
```bash
composer create-project symfony/skeleton projekt-steam
```

### Konfigurera Git:
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/Gaara25/projet_web_steam.git
git branch -M main
git push -u origin main
```

### Använda beroenden i projektet:

#### Utvecklingsberoenden:
```bash
composer require --dev profiler maker
```

#### Produktionsberoenden:
  ```bash
  composer require twig form validator orm asset
  ```
- Dessa beroenden krävs för översättning och datumformatering:
  ```bash
  composer require symfony/translation
  composer require symfony/intl
  composer require twig/intl-extra
  ```

- Detta beroende krävs för säkerhet:
  ```bash
  composer require symfony/security-bundle
  ```

- Detta beroende används för filuppladdningar:
  ```bash
  composer require vich/uploader-bundle
  ```

- Detta beroende används för att skapa ett minimalt API som tillåter VueJS att kommunicera med Symfony-backenden.
  ```bash
  composer require api
  ```

- Detta beroende används för att konvertera Markdown-text till HTML.
  ```bash
  composer require erusev/parsedown
  ```

### Några användbara kommandon:
  
- Starta den lokala servern:  
  ```bash
  symfony local:server:start
  ```

- Starta MySQL på Linux:  
  ```bash
  sudo service mysql start
  ```
  eller på Windows:  
  ```bash
  net start mySQL80
  ```

- Kommandon för att hantera säkerhet och användarinloggningar:
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- Kommando för att skapa en lyssnare för att ändra `_locale` för att byta språk baserat på användarens preferens:
  ```bash
  php bin/console make:listener
  ```

---

## 🧱 Symfony-projektstruktur

### Databaskonfiguration
I `.env.local`-filen (ska skapas):
```env
DATABASE_URL="mysql://user:pwd@localhost:3306/DBSteam?serverVersion=8"
```

Skapa sedan databasen med kommandot:
```bash
php bin/console doctrine:database:create
```

### Skapade entiteter

#### 🧍‍♂️`User`
Kommando för att generera entiteten:  
```bash
php bin/console make:entity User
```
Fält:
- `id` (int)
- `username` (string)
- `email` (string)
- `avatar` (string, filväg)
- `avatarFile` (File, Vich\UploadableField)
- `updatedAt` (datetime_immutable)
- `createdAt` (datetime_immutable)

#### 🎮`Game`
Kommando för att generera entiteten:  
```bash
php bin/console make:entity Game
```
Fält:
- `id` (int)
- `title` (string)
- `image` (string, filväg eller Steam-URL)
- `developer` (string)
- `releaseDate` (date)

#### 📊`GameStat`
Kommando för att generera entiteten:  
```bash
php bin/console make:entity GameStat
```
Fält:
- `id` (int)
- `hoursPlayed` (int)
- `lastPlayed` (datetime_immutable)
- **Relationer**:
  - `user` → ManyToOne till `User`
  - `game` → ManyToOne till `Game`

#### 💬`Comment`
Kommando för att generera entiteten:  
```bash
php bin/console make:entity Comment
```
Fält:
- `id` (int)
- `content` (text)
- `createdAt` (datetime_immutable)
- **Relationer**:
  - `user` → ManyToOne till `User`

#### 🔒`UserAuthenticator`
Kommando för att generera entiteten:  
```bash
php bin/console make:user
```
Fält:
- `id` (int)
- `email` (string)
- `roles` (array)
- `password` (string)

---

### Generera och köra migrationer
- Generera migrationer:  
  ```bash
  php bin/console make:migration
  ```
- Kör migrationer:  
  ```bash
  php bin/console doctrine:migrations:migrate
  ```

---

### Generera CRUD
För varje entitet genererade jag CRUD-operationer med följande kommandon:
```bash
php bin/console make:crud User
php bin/console make:crud Game
php bin/console make:crud GameStat
php bin/console make:crud Comment
```

---