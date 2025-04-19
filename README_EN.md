# 📦 Symfony Project - Steam Profile Reproduction

---

## Documentation

https://www.youtube.com/watch?v=cDY2p1CTkPo  
https://www.figma.com/community/file/1302616100790619521/steam-redesign

---

## 🎯 Objective
Create a dynamic website using Symfony (PHP) and VueJS to replicate a personalized Steam user profile with:
- User management (username, avatar, etc.) ✅
- Games and game statistics ✅
- Implementation of a minimal API for VueJS ❌
- A clean and relational base structure ✅

### 🎯 Secondary Objective
- Display dates in French ✅
- Avatar upload ✅
- Allow users to change the language based on their preference ✅
- Add security so only the admin can access CRUD operations ✅

---

## 🏗️ Setting up the Symfony Project

### Project Creation:
```bash
composer create-project symfony/skeleton projet-steam
```

### Configure Git:
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/Gaara25/projet_web_steam.git
git branch -M main
git push -u origin main
```

### Dependencies used throughout the project:

#### Development dependencies:
```bash
composer require --dev profiler maker
```

#### Production dependencies:
```bash
composer require twig form validator orm asset
```
- These dependencies are required for translation and date formatting:
```bash
composer require symfony/translation
composer require symfony/intl
composer require twig/intl-extra
```

- This dependency is required for security:
```bash
composer require symfony/security-bundle
```

- This dependency is used for file uploads:
```bash
composer require vich/uploader-bundle
```

### Some useful commands:
  
- Start the local server:  
  ```bash
  symfony local:server:start
  ```

- Start MySQL on Linux:  
  ```bash
  sudo service mysql start
  ```
  or on Windows:  
  ```bash
  net start mySQL80
  ```

- Commands for enhanced security:
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- Command to create a listener to modify `_locale` for changing the language based on user preference:
  ```bash
  php bin/console make:listener
  ```

---

## 🧱 Symfony Project Structure

### Database Configuration
In the `.env.local` file (to be created):
```env
DATABASE_URL="mysql://user:pwd@localhost:3306/DBSteam?serverVersion=8"
```

Then, create the database with the command:
```bash
php bin/console doctrine:database:create
```

### Created Entities

#### 🧍‍♂️`User`
Command to generate the entity:  
```bash
php bin/console make:entity User
```
Fields:
- `id` (int)
- `username` (string)
- `email` (string)
- `avatar` (string, file path)
- `avatarFile` (File, Vich\UploadableField)
- `updatedAt` (datetime_immutable)
- `createdAt` (datetime_immutable)

#### 🎮`Game`
Command to generate the entity:  
```bash
php bin/console make:entity Game
```
Fields:
- `id` (int)
- `title` (string)
- `image` (string, file path or Steam URL)
- `developer` (string)
- `releaseDate` (date)

#### 📊`GameStat`
Command to generate the entity:  
```bash
php bin/console make:entity GameStat
```
Fields:
- `id` (int)
- `hoursPlayed` (int)
- `lastPlayed` (datetime_immutable)
- **Relations**:
  - `user` → ManyToOne to `User`
  - `game` → ManyToOne to `Game`

#### 💬`Comment`
Command to generate the entity:  
```bash
php bin/console make:entity Comment
```
Fields:
- `id` (int)
- `content` (text)
- `createdAt` (datetime_immutable)
- **Relations**:
  - `user` → ManyToOne to `User`

#### 🔒`UserAuthenticator`
Command to generate the entity:  
```bash
php bin/console make:user
```
Fields:
- `id` (int)
- `email` (string)
- `roles` (array)
- `password` (string)

---

### Generating and Running Migrations
- Generate migrations:  
  ```bash
  php bin/console make:migration
  ```
- Run migrations:  
  ```bash
  php bin/console doctrine:migrations:migrate
  ```

---

### Generating CRUD
For each entity, I generated CRUD operations with the following commands:
```bash
php bin/console make:crud User
php bin/console make:crud Game
php bin/console make:crud GameStat
php bin/console make:crud Comment
```

#### 🔄 Modifications

##### Updated `show` function in `GameController`

The `show` function was updated to display the details of a specific game based on its `id`.

##### Updated `buildForm` functions in `GameStatType` and `CommentType`

The `buildForm` function was updated to customize form fields, allowing the display of choices or user-friendly labels based on associated entity data, such as a person's `name` or a game's `title`.

##### Updated `__construct` function in `Comment`

The `__construct` function was updated to automatically initialize the `createdAt` field with the current date and time.

##### Updated each `templates`

The `format_date` modifications were made to ensure proper date formatting.

---