# 📦 Проект Symfony - Воспроизведение профиля Steam

---

## 🎯 Цель проекта
Создать динамический веб-сайт на Symfony (PHP) и VueJS, воспроизводящий профиль пользователя Steam с возможностями:

### Symfony
- Управление пользователями (ник, аватар и др.) ✅
- Игры и игровые статистики ✅
- Реализация минимального API для VueJS ✅
- Чистая и реляционная базовая структура ✅

#### 🎯 Дополнительные цели
- Отображение дат на выбранном языке ✅
- Загрузка аватара ✅
- Возможность смены языка по предпочтению пользователя ✅
- Добавление безопасности, чтобы только администратор мог видеть интерфейсы CRUD ✅

### VueJS
- Использование нескольких компонентов ✅
- Использование роутера ✅
- Использование pinia ✅
- Часть сайта будет использовать API Symfony для динамического отображения данных. ❌

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
![Главная страница](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-home.png?raw=true)

### Профиль пользователя
![Профиль пользователя](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-profile.png?raw=true)

### Интерфейс CRUD для администратора 
<!-- Пароль в моем дампе: "admin", а email: "admin@gmail.com". -->
![Интерфейс CRUD для администратора](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-admin.png?raw=true)

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
  php bin/console make:listener LocaleSubscriber
      1. KernelEvents::REQUEST
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

## 🏗️ Настройка проекта VueJS

- Эта зависимость необходима для обеспечения совместимости между модулями PHP и JavaScript в этом проекте.
  ```bash
  composer require symfony/webpack-encore-bundle
  ```

- Установка необходимых зависимостей.
  ```bash
  npm install vue-router@4 pinia axios react react-dom prop-types vue-loader@^17.0.0
  ```

---

## 🌱 Эко-дизайн проекта

### Аудит RGAA (Общие рекомендации по улучшению доступности)
Был проведён аудит для проверки соответствия проекта стандарту RGAA:
- **Семантическая структура**: Корректное использование HTML-тегов (`header`, `nav`, `main`, `footer` и др.) для обеспечения доступной навигации.
- **Контрастность**: Используемые цвета соответствуют рекомендуемым коэффициентам контрастности для обеспечения читаемости.
- **Навигация с клавиатуры**: Все основные функции доступны с клавиатуры.
- **Альтернативные тексты**: Изображения имеют релевантные атрибуты `alt`.
- **Формы**: Поля форм правильно подписаны и доступны.

### Аудит RGESN (Общие рекомендации по эко-дизайну цифровых сервисов)
Аудит RGESN позволил выявить и применить несколько лучших практик:
- **Ленивая загрузка**: Внедрена отложенная загрузка изображений для снижения экологического воздействия при загрузке страниц.
- **Минимизация зависимостей**: Установлены только необходимые библиотеки на фронтенде и бэкенде.
- **Управление кэшем**: Использование кэша браузера для ограничения ненужных запросов к серверу.
- **Оптимизированный API**: Эндпоинты Symfony возвращают только необходимые для отображения данные, что ограничивает объём передаваемых данных.

### Реализованные эко-действия
- **Удаление неиспользуемых ресурсов**: Регулярная очистка кода и удаление неиспользуемых зависимостей.
- **Документация**: Освещение вопросов эко-дизайна в документации проекта для поощрения ответственных будущих вкладов.

Эти действия способствуют тому, чтобы проект был более доступным, производительным и экологичным.