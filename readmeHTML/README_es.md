# 📦 Proyecto Symfony - Reproducción de Perfil de Steam

---

## 🎯 Objetivo
Crear un sitio web dinámico utilizando Symfony (PHP) y VueJS para replicar un perfil personalizado de usuario de Steam con:
- Gestión de usuarios (nombre de usuario, avatar, etc.) ✅
- Juegos y estadísticas de juegos ✅
- Implementación de una API mínima para VueJS ❌
- Una estructura base limpia y relacional ✅

- Gestionar fechas mostradas en el idioma mantenido ✅
- Subida de avatar ✅
- Permitir a los usuarios cambiar el idioma según su preferencia ✅
- Añadir seguridad para que solo el administrador pueda acceder a las operaciones CRUD ✅

---

## 🏗️ Configuración del Proyecto Symfony

### Creación del Proyecto:
```bash
composer create-project symfony/skeleton proyecto-steam
```

### Configurar Git:
```bash
git init
git add .
git commit -m "Commit inicial"
git remote add origin https://github.com/Gaara25/proyecto_web_steam.git
git branch -M main
git push -u origin main
```

### Dependencias utilizadas en el proyecto:

#### Dependencias de desarrollo:
```bash
composer require --dev profiler maker
```

#### Dependencias de producción:
```bash
composer require twig form validator orm asset
```
- Estas dependencias son necesarias para la traducción y el formato de fechas:
```bash
composer require symfony/translation
composer require symfony/intl
composer require twig/intl-extra
```

- Esta dependencia es necesaria para la seguridad:
```bash
composer require symfony/security-bundle
```

- Esta dependencia se utiliza para la subida de archivos:
```bash
composer require vich/uploader-bundle
```
- Esta dependencia se utiliza para configurar una API mínima que permita a VueJS comunicarse con el backend de Symfony.
  ```bash
  composer require api
  ```

- Esta dependencia se utiliza para convertir texto Markdown en HTML.
  ```bash
  composer require erusev/parsedown
  ```

### Algunos comandos útiles:
  
- Iniciar el servidor local:  
  ```bash
  symfony local:server:start
  ```

- Iniciar MySQL en Linux:  
  ```bash
  sudo service mysql start
  ```
  o en Windows:  
  ```bash
  net start mySQL80
  ```
- Comandos para gestionar la seguridad y los inicios de sesión de usuarios:
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- Comando para crear un listener que modifique `_locale` para cambiar el idioma según la preferencia del usuario:
  ```bash
  php bin/console make:listener
  ```

---

## 🧱 Estructura del Proyecto Symfony

### Configuración de la Base de Datos
En el archivo `.env.local` (a crear):
```env
DATABASE_URL="mysql://user:pwd@localhost:3306/DBSteam?serverVersion=8"
```

Luego, crea la base de datos con el comando:
```bash
php bin/console doctrine:database:create
```

### Entidades Creadas

#### 🧍‍♂️`User`
Comando para generar la entidad:  
```bash
php bin/console make:entity User
```
Campos:
- `id` (int)
- `username` (string)
- `email` (string)
- `avatar` (string, ruta del archivo)
- `avatarFile` (File, Vich\UploadableField)
- `updatedAt` (datetime_immutable)
- `createdAt` (datetime_immutable)

#### 🎮`Game`
Comando para generar la entidad:  
```bash
php bin/console make:entity Game
```
Campos:
- `id` (int)
- `title` (string)
- `image` (string, ruta del archivo o URL de Steam)
- `developer` (string)
- `releaseDate` (date)

#### 📊`GameStat`
Comando para generar la entidad:  
```bash
php bin/console make:entity GameStat
```
Campos:
- `id` (int)
- `hoursPlayed` (int)
- `lastPlayed` (datetime_immutable)
- **Relaciones**:
  - `user` → ManyToOne a `User`
  - `game` → ManyToOne a `Game`

#### 💬`Comment`
Comando para generar la entidad:  
```bash
php bin/console make:entity Comment
```
Campos:
- `id` (int)
- `content` (text)
- `createdAt` (datetime_immutable)
- **Relaciones**:
  - `user` → ManyToOne a `User`

#### 🔒`UserAuthenticator`
Comando para generar la entidad:  
```bash
php bin/console make:user
```
Campos:
- `id` (int)
- `email` (string)
- `roles` (array)
- `password` (string)

---

### Generar y Ejecutar Migraciones
- Generar migraciones:  
  ```bash
  php bin/console make:migration
  ```
- Ejecutar migraciones:  
  ```bash
  php bin/console doctrine:migrations:migrate
  ```

---

### Generar CRUD
Para cada entidad, generé operaciones CRUD con los siguientes comandos:
```bash
php bin/console make:crud User
php bin/console make:crud Game
php bin/console make:crud GameStat
php bin/console make:crud Comment
```

#### 🔄 Modificaciones

##### Función `show` actualizada en `GameController`

La función `show` fue actualizada para mostrar los detalles de un juego específico basado en su `id`.

##### Funciones `buildForm` actualizadas en `GameStatType` y `CommentType`

La función `buildForm` fue actualizada para personalizar los campos del formulario, permitiendo la visualización de opciones o etiquetas amigables para el usuario basadas en los datos de la entidad asociada, como el `name` de una persona o el `title` de un juego.

##### Función `__construct` actualizada en `Comment`

La función `__construct` fue actualizada para inicializar automáticamente el campo `createdAt` con la fecha y hora actual.

##### Actualización de cada `templates`

Se realizaron modificaciones de `format_date` para garantizar un formato de fecha adecuado.

---