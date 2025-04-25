# 📦 Проект Symfony - Воспроизведение профиля Steam

---

## 🎯 Цель
Создать динамический веб-сайт с использованием Symfony (PHP) и VueJS для воспроизведения персонализированного профиля пользователя Steam с:
- Управлением пользователями (имя пользователя, аватар и т.д.) ✅
- Играми и игровой статистикой ✅
- Реализацией минимального API для VueJS ❌
- Чистой и реляционной структурой базы данных ✅

### 🎯 Второстепенная цель
- Управление датами, отображаемыми на поддерживаемом языке ✅
- Загрузка аватара ✅
- Возможность изменения языка пользователем ✅
- Добавление безопасности, чтобы только администратор мог получить доступ к операциям CRUD ✅

---

## 🚀 Установка

### 🛠️ Предварительные требования

- PHP 8.1 или выше
- Composer
- Symfony CLI
- MySQL 8.0 или выше
- Node.js

### Клонирование репозитория:
```bash
git clone https://github.com/Gaara25/projet_web_steam.git
cd projet_web_steam
```

## 🤝 Вклад в проект
Вклад приветствуется! Чтобы внести изменения:
- Синхронизируйте свою форк-версию с основным репозиторием (`git pull origin main`).
- Создайте ветку для своей функции (`git checkout -b feature/my-feature`).
- Зафиксируйте свои изменения (`git commit -m "Add my feature"`).
- Отправьте свою ветку (`git push origin feature/my-feature`).

---

## 📸 Скриншоты

### Главная страница
![Главная страница](../public/screenshot/screenshot-home.png)

### Профиль пользователя
![Профиль пользователя](../public/screenshot/screenshot-profile.png)

### Интерфейс CRUD для администратора <!-- Пароль в моем дампе: "admin", а email: "admin@gmail.com". -->
![Интерфейс CRUD для администратора](../public/screenshot/screenshot-admin.png)

---

## 🏗️ Настройка проекта Symfony

### Создание проекта:
```bash
composer create-project symfony/skeleton projet-steam
```

### Настройка Git:
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/Gaara25/projet_web_steam.git
git branch -M main
git push -u origin main
```

### Зависимости, используемые в проекте:

#### Зависимости для разработки:
```bash
composer require --dev profiler maker
```

#### Зависимости для продакшена:
  ```bash
  composer require twig form validator orm asset
  ```
- Эти зависимости необходимы для перевода и форматирования дат:
  ```bash
  composer require symfony/translation
  composer require symfony/intl
  composer require twig/intl-extra
  ```

- Эта зависимость необходима для безопасности:
  ```bash
  composer require symfony/security-bundle
  ```

- Эта зависимость используется для загрузки файлов:
  ```bash
  composer require vich/uploader-bundle
  ```

- Эта зависимость используется для настройки минимального API, позволяющего VueJS взаимодействовать с бэкендом Symfony.
  ```bash
  composer require api
  ```

- Эта зависимость используется для преобразования текста Markdown в HTML.
  ```bash
  composer require erusev/parsedown
  ```

### Полезные команды:
  
- Запуск локального сервера:  
  ```bash
  symfony local:server:start
  ```

- Запуск MySQL на Linux:  
  ```bash
  sudo service mysql start
  ```
  или на Windows:  
  ```bash
  net start mySQL80
  ```

- Команды для управления безопасностью и входом пользователей:
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- Команда для создания слушателя для изменения `_locale` для смены языка на основе предпочтений пользователя:
  ```bash
  php bin/console make:listener
  ```

---

## 🧱 Структура проекта Symfony

### Конфигурация базы данных
В файле `.env.local` (необходимо создать):
```env
DATABASE_URL="mysql://user:pwd@localhost:3306/DBSteam?serverVersion=8"
```

Затем создайте базу данных с помощью команды:
```bash
php bin/console doctrine:database:create
```

### Созданные сущности

#### 🧍‍♂️`User`
Команда для генерации сущности:  
```bash
php bin/console make:entity User
```
Поля:
- `id` (int)
- `username` (string)
- `email` (string)
- `avatar` (string, путь к файлу)
- `avatarFile` (File, Vich\UploadableField)
- `updatedAt` (datetime_immutable)
- `createdAt` (datetime_immutable)

#### 🎮`Game`
Команда для генерации сущности:  
```bash
php bin/console make:entity Game
```
Поля:
- `id` (int)
- `title` (string)
- `image` (string, путь к файлу или URL Steam)
- `developer` (string)
- `releaseDate` (date)

#### 📊`GameStat`
Команда для генерации сущности:  
```bash
php bin/console make:entity GameStat
```
Поля:
- `id` (int)
- `hoursPlayed` (int)
- `lastPlayed` (datetime_immutable)
- **Связи**:
  - `user` → ManyToOne к `User`
  - `game` → ManyToOne к `Game`

#### 💬`Comment`
Команда для генерации сущности:  
```bash
php bin/console make:entity Comment
```
Поля:
- `id` (int)
- `content` (text)
- `createdAt` (datetime_immutable)
- **Связи**:
  - `user` → ManyToOne к `User`

#### 🔒`UserAuthenticator`
Команда для генерации сущности:  
```bash
php bin/console make:user
```
Поля:
- `id` (int)
- `email` (string)
- `roles` (array)
- `password` (string)

---

### Генерация и выполнение миграций
- Генерация миграций:  
  ```bash
  php bin/console make:migration
  ```
- Выполнение миграций:  
  ```bash
  php bin/console doctrine:migrations:migrate
  ```

---

### Генерация CRUD
Для каждой сущности я сгенерировал операции CRUD с помощью следующих команд:
```bash
php bin/console make:crud User
php bin/console make:crud Game
php bin/console make:crud GameStat
php bin/console make:crud Comment
```

---