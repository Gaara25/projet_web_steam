# 📦 Symfony-projekt - Steam-profilreproduktion

---

## 🎯 Syfte
Skapa en dynamisk webbplats med Symfony (PHP) och VueJS som återskapar en anpassad Steam-profil med:

### Symfony
- Hantering av användare (användarnamn, avatar…) ✅
- Spel och spelstatistik ✅
- Implementering av ett minimalt API för VueJS ✅
- En ren och relationell grundstruktur ✅

#### 🎯 Sekundärt syfte
- Hantera datumvisning på valt språk ✅
- Uppladdning av avatar ✅
- Möjlighet att byta språk efter användarens preferens ✅
- Lägga till säkerhet så att endast admin kan se CRUD ✅

### VueJS
- Användning av flera komponenter ✅
- Användning av router ✅
- Användning av pinia ✅
- En del av webbplatsen använder Symfony-API:t för att dynamiskt visa data. ❌

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
![Startsida](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-home.png?raw=true)

### Användarprofil
![Användarprofil](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-profile.png?raw=true)

### Admin CRUD-gränssnitt 
<!-- Lösenordet i min dump är "admin" och e-posten är "admin@gmail.com". -->
![Admin CRUD-gränssnitt](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-admin.png?raw=true)

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
  php bin/console make:listener LocaleSubscriber
      1. KernelEvents::REQUEST
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

## 🏗️ Installera VueJS-projektet

- Detta beroende krävs för att säkerställa kompatibilitet mellan PHP- och JavaScript-moduler i projektet.
  ```bash
  composer require symfony/webpack-encore-bundle
  ```

- Installera nödvändiga beroenden.
  ```bash
  npm install vue-router@4 pinia axios react react-dom prop-types vue-loader@^17.0.0
  ```

---

## 🌱 Ekodesign av projektet

### RGAA-granskning (Tillgänglighet)
En granskning har genomförts för att säkerställa att projektet följer RGAA:
- **Semantisk struktur**: Korrekt användning av HTML-taggar (`header`, `nav`, `main`, `footer`, etc.) för tillgänglig navigering.
- **Kontraster**: Färgerna uppfyller rekommenderade kontrastkrav för läsbarhet.
- **Tangentbordsnavigering**: Alla huvudfunktioner är tillgängliga via tangentbordet.
- **Alternativtext**: Bilder har relevanta `alt`-attribut.
- **Formulär**: Formulärfält är korrekt märkta och tillgängliga.

### RGESN-granskning (Ekodesign)
RGESN-granskningen har identifierat och implementerat flera goda metoder:
- **Lazy loading**: Bilder laddas in vid behov för att minska miljöpåverkan.
- **Minimering av beroenden**: Endast nödvändiga bibliotek installeras på frontend och backend.
- **Cachehantering**: Webbläsarcache används för att minska onödiga serverförfrågningar.
- **Optimerat API**: Endast nödvändiga data skickas från Symfony till frontend.

### Genomförda ekodesignåtgärder
- **Borttagning av oanvända resurser**: Regelbunden kodstädning och borttagning av onödiga beroenden.
- **Dokumentation**: Ekodesign lyfts fram i projektets dokumentation för att uppmuntra ansvarsfulla framtida bidrag.

Dessa åtgärder bidrar till att göra projektet mer tillgängligt, effektivt och miljövänligt.