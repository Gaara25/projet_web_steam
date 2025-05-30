# 📦 Proyecto Symfony - Reproducción de Perfil de Steam

---

## 🎯 Objetivo
Crear un sitio web dinámico utilizando Symfony (PHP) y VueJS para replicar un perfil de usuario personalizado de Steam con:
- Gestión de usuarios (nombre de usuario, avatar, etc.) ✅
- Juegos y estadísticas de juegos ✅
- Implementación de una API mínima para VueJS ✅
- Una estructura base limpia y relacional ✅

### 🎯 Objetivo Secundario
- Gestionar fechas mostradas en el idioma seleccionado ✅
- Subida de avatar ✅
- Permitir a los usuarios cambiar el idioma según su preferencia ✅
- Añadir seguridad para que solo el administrador pueda acceder a las operaciones CRUD ✅

---

## 🚀 Instalación

### 🛠️ Requisitos Previos

- PHP 8.1 o superior
- Composer
- Symfony CLI
- MySQL 8.0 o superior
- Node.js

### Clona el repositorio:
  ```bash
  git clone https://github.com/Gaara25/projet_web_steam.git
  cd projet_web_steam
  ```

## 🤝 Contribuciones
¡Las contribuciones son bienvenidas! Para contribuir:
  - Sincroniza tu fork con el repositorio principal (`git pull origin main`).
  - Crea una rama para tu funcionalidad (`git checkout -b feature/mi-funcionalidad`).
  - Realiza tus cambios y haz un commit (`git commit -m "Añadida mi funcionalidad"`).
  - Sube tu rama (`git push origin feature/mi-funcionalidad`).

---

## 📸 Capturas de Pantalla

### Página de inicio
![Página de inicio](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-home.png?raw=true)

### Perfil de usuario
![Perfil de usuario](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-profile.png?raw=true)

### CRUD en modo administrador 
<!-- La contraseña en mi volcado es "admin" y el correo es "admin@gmail.com". -->
![Interfaz CRUD Admin](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-admin.png?raw=true)

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
git remote add origin https://github.com/Gaara25/projet_web_steam.git
git branch -M main
git push -u origin main
```

### Dependencias utilizadas a lo largo del proyecto:

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

- Esta dependencia se utiliza para subir archivos:
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
  php bin/console make:listener LocaleSubscriber
      1. KernelEvents::REQUEST
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

---

## 🏗️ Configuración del proyecto VueJS

- Esta dependencia es necesaria para asegurar la compatibilidad entre los módulos PHP y JavaScript de este proyecto.
  ```bash
  composer require symfony/webpack-encore-bundle
  ```

- Instalación de las dependencias necesarias.
  ```bash
  npm install vue-router@4 pinia axios react react-dom prop-types vue-loader@^17.0.0
  ```

---

## 🌱 Eco-diseño del proyecto

### Auditoría RGAA (Referencial General de Mejora de la Accesibilidad)
Se realizó una auditoría para verificar la conformidad del proyecto con el RGAA:
- **Estructura semántica**: Uso adecuado de etiquetas HTML (`header`, `nav`, `main`, `footer`, etc.) para garantizar una navegación accesible.
- **Contrastes**: Los colores utilizados respetan las proporciones de contraste recomendadas para asegurar la legibilidad de los contenidos.
- **Navegación por teclado**: Todas las funcionalidades principales son accesibles mediante teclado.
- **Alternativas textuales**: Las imágenes cuentan con atributos `alt` pertinentes.
- **Formularios**: Los campos de formulario están correctamente etiquetados y son accesibles.

### Auditoría RGESN (Referencial General de Eco-diseño de Servicios Digitales)
La auditoría RGESN permitió identificar y aplicar varias buenas prácticas:
- **Carga diferida (Lazy loading)**: Implementación de carga diferida de imágenes para reducir el impacto ambiental al cargar las páginas.
- **Minimización de dependencias**: Solo se instalan las librerías necesarias tanto en frontend como en backend.
- **Gestión de caché**: Uso de caché del navegador para limitar solicitudes innecesarias al servidor.
- **API optimizada**: Los endpoints expuestos por Symfony solo devuelven los datos necesarios para la visualización, limitando así el volumen de datos intercambiados.

### Acciones de eco-diseño implementadas
- **Eliminación de recursos no utilizados**: Limpieza regular del código y eliminación de dependencias no utilizadas.
- **Documentación**: Concienciación sobre el eco-diseño en la documentación del proyecto para fomentar futuras contribuciones responsables.

Estas acciones contribuyen a que el proyecto sea más accesible, eficiente y respetuoso con el entorno digital.