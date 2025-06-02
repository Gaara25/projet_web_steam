# 📦 Symfony Project - Відтворення профілю Steam

---

## 🎯 Мета
Створити динамічний вебсайт із Symfony (PHP) та VueJS, що відтворює профіль Steam для користувача з такими можливостями:

### Symfony
- Управління користувачами (нікнейм, аватар тощо) ✅
- Ігри та статистика ігор ✅
- Реалізація мінімального API для VueJS ✅
- Чиста та реляційна базова структура ✅

#### 🎯 Додаткова мета
- Відображення дат у локалізованому форматі ✅
- Завантаження аватара ✅
- Можливість змінювати мову відповідно до вподобань користувача ✅
- Додати безпеку, щоб лише адміністратор міг бачити CRUD ✅

### VueJS
- Використання кількох компонентів ✅
- Використання роутера ✅
- Використання pinia ✅
- Частина сайту використовує API Symfony для динамічного відображення даних. ❌

---

## 🚀 Встановлення

### 🛠️ Попередні вимоги

- PHP 8.1 або вище
- Composer
- Symfony CLI
- MySQL 8.0 або вище
- Node.js

### Клонування репозиторію:
```bash
git clone https://github.com/Gaara25/projet_web_steam.git
cd projet_web_steam
```

## 🤝 Внесок у проект
Внески вітаються! Щоб зробити внесок:
- Синхронізуйте свій форк із основним репозиторієм (`git pull origin main`).
- Створіть гілку для своєї функції (`git checkout -b feature/my-feature`).
- Зафіксуйте свої зміни (`git commit -m "Add my feature"`).
- Відправте свою гілку (`git push origin feature/my-feature`).

---

## 📸 Знімки екрана

### Головна сторінка
![Головна сторінка](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-home.png?raw=true)

### Профіль користувача
![Профіль користувача](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-profile.png?raw=true)

### Інтерфейс CRUD для адміністратора <!-- Пароль у моєму дампі - "admin", а електронна пошта - "admin@gmail.com". -->
![Інтерфейс CRUD для адміністратора](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-admin.png?raw=true)


---

## 🏗️ Налаштування проекту Symfony

### Створення проекту:
```bash
composer create-project symfony/skeleton projet-steam
```

### Налаштування Git:
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/Gaara25/projet_web_steam.git
git branch -M main
git push -u origin main
```

### Залежності, використані у проекті:

#### Залежності для розробки:
```bash
composer require --dev profiler maker
```

#### Залежності для продакшну:
  ```bash
  composer require twig form validator orm asset
  ```
- Ці залежності потрібні для перекладу та форматування дат:
  ```bash
  composer require symfony/translation
  composer require symfony/intl
  composer require twig/intl-extra
  ```

- Ця залежність потрібна для безпеки:
  ```bash
  composer require symfony/security-bundle
  ```

- Ця залежність використовується для завантаження файлів:
  ```bash
  composer require vich/uploader-bundle
  ```

- Ця залежність використовується для налаштування мінімального API, що дозволяє VueJS спілкуватися з бекендом Symfony.
  ```bash
  composer require api
  ```

- Ця залежність використовується для конвертації тексту Markdown у HTML.
  ```bash
  composer require erusev/parsedown
  ```

### Корисні команди:
  
- Запуск локального сервера:  
  ```bash
  symfony local:server:start
  ```

- Запуск MySQL у Linux:  
  ```bash
  sudo service mysql start
  ```
  або у Windows:  
  ```bash
  net start mySQL80
  ```

- Команди для управління безпекою та входом користувачів:
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- Команда для створення слухача, щоб змінювати `_locale` для зміни мови відповідно до уподобань користувача:
  ```bash
  php bin/console make:listener LocaleSubscriber
      1. KernelEvents::REQUEST
  ```

---

## 🧱 Структура проекту Symfony

### Налаштування бази даних
У файлі `.env.local` (який потрібно створити):
```env
DATABASE_URL="mysql://user:pwd@localhost:3306/DBSteam?serverVersion=8"
```

Потім створіть базу даних за допомогою команди:
```bash
php bin/console doctrine:database:create
```

### Створені сутності

#### 🧍‍♂️`User`
Команда для генерації сутності:  
```bash
php bin/console make:entity User
```
Поля:
- `id` (int)
- `username` (string)
- `email` (string)
- `avatar` (string, шлях до файлу)
- `avatarFile` (File, Vich\UploadableField)
- `updatedAt` (datetime_immutable)
- `createdAt` (datetime_immutable)

#### 🎮`Game`
Команда для генерації сутності:  
```bash
php bin/console make:entity Game
```
Поля:
- `id` (int)
- `title` (string)
- `image` (string, шлях до файлу або URL Steam)
- `developer` (string)
- `releaseDate` (date)

#### 📊`GameStat`
Команда для генерації сутності:  
```bash
php bin/console make:entity GameStat
```
Поля:
- `id` (int)
- `hoursPlayed` (int)
- `lastPlayed` (datetime_immutable)
- **Зв'язки**:
  - `user` → ManyToOne до `User`
  - `game` → ManyToOne до `Game`

#### 💬`Comment`
Команда для генерації сутності:  
```bash
php bin/console make:entity Comment
```
Поля:
- `id` (int)
- `content` (text)
- `createdAt` (datetime_immutable)
- **Зв'язки**:
  - `user` → ManyToOne до `User`

#### 🔒`UserAuthenticator`
Команда для генерації сутності:  
```bash
php bin/console make:user
```
Поля:
- `id` (int)
- `email` (string)
- `roles` (array)
- `password` (string)

---

### Генерація та виконання міграцій
- Генерація міграцій:  
  ```bash
  php bin/console make:migration
  ```
- Виконання міграцій:  
  ```bash
  php bin/console doctrine:migrations:migrate
  ```

---

### Генерація CRUD
Для кожної сутності я згенерував CRUD-операції за допомогою наступних команд:
```bash
php bin/console make:crud User
php bin/console make:crud Game
php bin/console make:crud GameStat
php bin/console make:crud Comment
```

---

## 🏗️ Налаштування проекту VueJS

- Ця залежність необхідна для забезпечення сумісності між модулями PHP та JavaScript у цьому проекті.
  ```bash
  composer require symfony/webpack-encore-bundle
  ```

- Встановлення необхідних залежностей.
  ```bash
  npm install vue-router@4 pinia axios react react-dom prop-types vue-loader@^17.0.0
  ```

---

## 🌱 Екоконцепція проекту

### Аудит RGAA (Загальний довідник з підвищення доступності)
Був проведений аудит для перевірки відповідності проекту RGAA:
- **Семантична структура**: Коректне використання HTML-тегів (`header`, `nav`, `main`, `footer` тощо) для забезпечення доступної навігації.
- **Контрасти**: Використані кольори відповідають рекомендованим коефіцієнтам контрастності для забезпечення читабельності контенту.
- **Навігація з клавіатури**: Усі основні функції доступні з клавіатури.
- **Текстові альтернативи**: Зображення мають відповідні атрибути `alt`.
- **Форми**: Поля форм правильно позначені та доступні.

### Аудит RGESN (Загальний довідник з екоконцепції цифрових сервісів)
Аудит RGESN дозволив визначити та впровадити кілька кращих практик:
- **Ліниве завантаження**: Впроваджено відкладене завантаження зображень для зменшення екологічного впливу під час завантаження сторінок.
- **Мінімізація залежностей**: Встановлені лише необхідні бібліотеки для фронтенду та бекенду.
- **Кешування**: Використання кешу браузера для зменшення непотрібних запитів до сервера.
- **Оптимізоване API**: Ендпоінти Symfony повертають лише необхідні для відображення дані, обмежуючи обсяг переданих даних.

### Впроваджені дії з екоконцепції
- **Видалення невикористаних ресурсів**: Регулярне очищення коду та видалення невикористаних залежностей.
- **Документація**: Підвищення обізнаності щодо екоконцепції у документації проекту для заохочення відповідальних майбутніх внесків.

Ці дії сприяють підвищенню доступності, продуктивності та екологічності проекту.
