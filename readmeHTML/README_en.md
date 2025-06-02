# 📦 Symfony Project - Steam Profile Reproduction

---

## 🎯 Objective
Create a dynamic website using Symfony (PHP) and VueJS that reproduces a personalized Steam user profile with:

### Symfony
- User management (username, avatar, etc.) ✅
- Games and game statistics ✅
- Implementation of a minimal API for VueJS ✅
- A clean and relational base structure ✅

#### 🎯 Secondary Objective
- Display dates in the user's preferred language ✅
- Avatar upload ✅
- Ability to change the language according to user preference ✅
- Add security so only the admin can access CRUD interfaces ✅

### VueJS
- Use of multiple components ✅
- Use of the router ✅
- Use of Pinia ✅
- Part of the site will use the Symfony API to dynamically display data. ❌

---

## 🚀 Installation

### 🛠️ Prerequisites

- PHP 8.1 or higher
- Composer
- Symfony CLI
- MySQL 8.0 or higher
- Node.js

### Clone the repository:
```bash
git clone https://github.com/Gaara25/projet_web_steam.git
cd projet_web_steam
```

## 🤝 Contributions
Contributions are welcome! To contribute:
- Sync your fork with the main repository (`git pull origin main`).
- Create a branch for your feature (`git checkout -b feature/my-feature`).
- Commit your changes (`git commit -m "Add my feature"`).
- Push your branch (`git push origin feature/my-feature`).

---

## 📸 Screenshots

### Home Page
![Home Page](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-home.png)

### User Profile
![User Profile](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-profile.png)

### Admin CRUD Interface 
<!-- The password in my dump is "admin" and the email is "admin@gmail.com". -->
![Admin CRUD Interface](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-admin.png)

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

- This dependency is used to set up a minimal API allowing VueJS to communicate with the Symfony backend.
  ```bash
  composer require api
  ```

- This dependency is used to convert Markdown text into HTML.
  ```bash
  composer require erusev/parsedown
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

- Commands to manage security and user logins:
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- Command to create a listener to modify `_locale` for changing the language based on user preference:
  ```bash
  php bin/console make:listener LocaleSubscriber
      1. KernelEvents::REQUEST
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

---

## 🏗️ Setting up the VueJS Project

- This dependency is required to ensure compatibility between the PHP and JavaScript modules of this project.
  ```bash
  composer require symfony/webpack-encore-bundle
  ```

- Install the necessary dependencies.
  ```bash
  npm install vue-router@4 pinia axios react react-dom prop-types vue-loader@^17.0.0
  ```

---

## 🌱 Eco-design of the Project

### RGAA Audit (General Accessibility Improvement Reference)
An audit was conducted to verify the project's compliance with the RGAA:
- **Semantic structure**: Appropriate use of HTML tags (`header`, `nav`, `main`, `footer`, etc.) to ensure accessible navigation.
- **Contrast**: The colors used respect the recommended contrast ratios to ensure content readability.
- **Keyboard navigation**: All main features are accessible via keyboard.
- **Text alternatives**: Images have relevant `alt` attributes.
- **Forms**: Form fields are properly labeled and accessible.

### RGESN Audit (General Reference for Eco-design of Digital Services)
The RGESN audit identified and applied several best practices:
- **Lazy loading**: Implemented deferred image loading to reduce environmental impact when loading pages.
- **Minimizing dependencies**: Only necessary libraries are installed on both frontend and backend.
- **Cache management**: Browser cache is used to limit unnecessary server requests.
- **Optimized API**: Symfony endpoints only return the data necessary for display, thus limiting the volume of data exchanged.

### Eco-design actions implemented
- **Removal of unused resources**: Regular code cleanup and removal of unused dependencies.
- **Documentation**: Raising awareness of eco-design in the project documentation to encourage responsible future contributions.

These actions help make the project more accessible, efficient, and environmentally friendly.