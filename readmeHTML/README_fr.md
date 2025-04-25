# 📦 Projet Symfony - Reproduction de Profil Steam

---

## 🎯 Objectif
Créer un site web dynamique avec Symfony (PHP) et VueJS reproduisant le profil Steam d’un utilisateur personnalisé avec :
- Gestion des utilisateurs (pseudo, avatar…) ✅
- Jeux et statistiques de jeu ✅
- Mise en place d’une API minimale pour VueJS ✅
- Une structure de base propre et relationnelle ✅

### 🎯 Objectif secondaire
- Gérer des dates affichées en langage maintenu ✅
- Upload d’avatar ✅
- Pouvoir changer la langue selon la préférence de l'utilisateur ✅
- Ajouter une sécurité pour que seul l'admin puisse voir les CRUD ✅

---

## 🚀 Installation

### 🛠️ Prérequis

- PHP 8.1 ou supérieur
- Composer
- Symfony CLI
- MySQL 8.0 ou supérieur
- Node.js

### Clonez le dépôt :
  ```bash
  git clone https://github.com/Gaara25/projet_web_steam.git
  cd projet_web_steam
  ```

## 🤝 Contributions
Les contributions sont les bienvenues ! Pour contribuer :
  - Synchronisez votre fork avec le dépôt principal (`git pull origin main`).
  - Créez une branche pour votre fonctionnalité (`git checkout -b feature/ma-fonctionnalite`).
  - Commitez vos modifications (`git commit -m "Ajout de ma fonctionnalité"`).
  - Poussez votre branche (`git push origin feature/ma-fonctionnalite`).

---

## 📸 Captures d'écran

### Page d'accueil
![Page d'accueil](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-home.png?raw=true)

### Profil utilisateur
![Profil utilisateur](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-profile.png?raw=true)

### CRUD en mode admin
<!-- Le mot de passe dans mon dump est "admin" et le mail est "admin@gmail.com". -->
![Interface CRUD Admin](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-admin.png?raw=true)


---

## 🏗️ Mise en place du projet Symfony

### Création du projet :
```bash
composer create-project symfony/skeleton projet-steam
```

### Configurer Git :
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/Gaara25/projet_web_steam.git
git branch -M main
git push -u origin main
```

### Les dépendances utilisées tout du long :

#### Dépendances de développement :
  ```bash
  composer require --dev profiler maker
  ```

#### Dépendances de production :
  ```bash
  composer require twig form validator orm asset
  ```
- Ces dépendances sont nécessaires à la traduction et au format de la date :
  ```bash
  composer require symfony/translation
  composer require symfony/intl
  composer require twig/intl-extra
  ```

- Cette dépendance est nécessaires à la sécurité :
  ```bash
  composer require symfony/security-bundle
  ```

- Cette dépendance est utilisée pour gérer l’upload de fichiers
  ```bash
  composer require vich/uploader-bundle
  ```

- Cette dépendance est utilisée pour mettre en place une API minimale permettant à VueJS de communiquer avec le backend Symfony.
  ```bash
  composer require api
  ```

- Cette dépendance est utilisée pour convertir du texte Markdown en HTML.
  ```bash
  composer require erusev/parsedown
  ```

### Quelques commandes utiles :
  
- Lancer le serveur local :  
  ```bash
  symfony local:server:start
  ```

- Démarrer MySQL, sous Linux :  
  ```bash
  sudo service mysql start
  ```
  ou, sous Windows :  
  ```bash
  net start mySQL80
  ```

- Commandes pour gérer la sécurité et les connexions utilisateur :
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- Commande pour créer un listener qui modifie `_locale` afin de changer la langue selon la préférence de l'utilisateur
  ```bash
  php bin/console make:listener LocaleSubscriber
      1. KernelEvents::REQUEST
  ```

---

## 🧱 Structure du projet Symfony

### Configuration de la base de données
Dans le fichier .env.local (à créer) :
```env
DATABASE_URL="mysql://user:pwd@localhost:3306/DBSteam?serverVersion=8"
```

Ensuite, créer la base de données avec la commande :
```bash
php bin/console doctrine:database:create
```

### Entités créées

#### 🧍‍♂️`User`
Commande pour générer l’entité :  
```bash
php bin/console make:entity User
```
Champs :
- `id` (int)
- `username` (string)
- `email` (string)
- `avatar` (string, chemin de fichier)
- `avatarFile` (File, Vich\UploadableField)
- `updatedAt` (datetime_immutable)
- `createdAt` (datetime_immutable)

#### 🎮`Game`
Commande pour générer l’entité :  
```bash
php bin/console make:entity Game
```
Champs :
- `id` (int)
- `title` (string)
- `image` (string, chemin de fichier ou URL Steam)
- `developer` (string)
- `releaseDate` (date)

#### 📊`GameStat`
Commande pour générer l’entité :  
```bash
php bin/console make:entity GameStat
```
Champs :
- `id` (int)
- `hoursPlayed` (int)
- `lastPlayed` (datetime_immutable)
- **Relations** :
  - `user` → ManyToOne vers `User`
  - `game` → ManyToOne vers `Game`

#### 💬`Comment`
Commande pour générer l’entité :  
```bash
php bin/console make:entity Comment
```
Champs :
- `id` (int)
- `content` (text)
- `createdAt` (datetime_immutable)
- **Relations** :
  - `user` → ManyToOne vers `User`

#### 🔒`UserAuthenticator`
Commande pour générer l’entité :  
```bash
php bin/console make:user
```
Champs :
- `id` (int)
- `email` (string)
- `roles` (array)
- `password` (string)

---

### Génération et exécution des migrations
- Générer les migrations :  
  ```bash
  php bin/console make:migration
  ```
- Exécuter les migrations :  
  ```bash
  php bin/console doctrine:migrations:migrate
  ```

---

### Génération des CRUD
Pour chaque entité, j'ai générer les CRUD avec les commandes suivantes :
```bash
php bin/console make:crud User
php bin/console make:crud Game
php bin/console make:crud GameStat
php bin/console make:crud Comment
```

---