# 📦 مشروع Symfony - استنساخ ملف تعريف Steam

---

## 🎯 الهدف
إنشاء موقع ديناميكي باستخدام Symfony (PHP) وVueJS لاستنساخ ملف تعريف مستخدم Steam مخصص مع:
- إدارة المستخدمين (اسم المستخدم، الصورة الرمزية، إلخ.) ✅
- الألعاب وإحصائيات الألعاب ✅
- تنفيذ واجهة برمجة تطبيقات صغيرة لـ VueJS ❌
- هيكل قاعدة بيانات نظيف وعلاقاتي ✅

### 🎯 الهدف الثانوي
- إدارة التواريخ المعروضة باللغة المختارة ✅
- تحميل الصورة الرمزية ✅
- السماح للمستخدمين بتغيير اللغة بناءً على تفضيلاتهم ✅
- إضافة أمان بحيث يمكن للمسؤول فقط الوصول إلى عمليات CRUD ✅

---

## 🏗️ إعداد مشروع Symfony

### إنشاء المشروع:
```bash
composer create-project symfony/skeleton projet-steam
```

### إعداد Git:
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/Gaara25/projet_web_steam.git
git branch -M main
git push -u origin main
```

### التبعيات المستخدمة في المشروع:

#### تبعيات التطوير:
```bash
composer require --dev profiler maker
```

#### تبعيات الإنتاج:
  ```bash
  composer require twig form validator orm asset
  ```
- هذه التبعيات مطلوبة للترجمة وتنسيق التواريخ:
  ```bash
  composer require symfony/translation
  composer require symfony/intl
  composer require twig/intl-extra
  ```

- هذه التبعية مطلوبة للأمان:
  ```bash
  composer require symfony/security-bundle
  ```

- هذه التبعية تُستخدم لتحميل الملفات:
  ```bash
  composer require vich/uploader-bundle
  ```

- هذه التبعية تُستخدم لإعداد واجهة برمجة تطبيقات صغيرة للسماح لـ VueJS بالتواصل مع الخلفية Symfony.
  ```bash
  composer require api
  ```

- هذه التبعية تُستخدم لتحويل نصوص Markdown إلى HTML.
  ```bash
  composer require erusev/parsedown
  ```

### بعض الأوامر المفيدة:
  
- بدء الخادم المحلي:  
  ```bash
  symfony local:server:start
  ```

- بدء MySQL على Linux:  
  ```bash
  sudo service mysql start
  ```
  أو على Windows:  
  ```bash
  net start mySQL80
  ```

- أوامر لإدارة الأمان وتسجيل دخول المستخدمين:
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- أمر لإنشاء مستمع لتعديل `_locale` لتغيير اللغة بناءً على تفضيلات المستخدم:
  ```bash
  php bin/console make:listener
  ```

---

## 🧱 هيكل مشروع Symfony

### إعداد قاعدة البيانات
في ملف `.env.local` (يجب إنشاؤه):
```env
DATABASE_URL="mysql://user:pwd@localhost:3306/DBSteam?serverVersion=8"
```

ثم، قم بإنشاء قاعدة البيانات باستخدام الأمر:
```bash
php bin/console doctrine:database:create
```

### الكيانات التي تم إنشاؤها

#### 🧍‍♂️`User`
الأمر لإنشاء الكيان:  
```bash
php bin/console make:entity User
```
الحقول:
- `id` (int)
- `username` (string)
- `email` (string)
- `avatar` (string, file path)
- `avatarFile` (File, Vich\UploadableField)
- `updatedAt` (datetime_immutable)
- `createdAt` (datetime_immutable)

#### 🎮`Game`
الأمر لإنشاء الكيان:  
```bash
php bin/console make:entity Game
```
الحقول:
- `id` (int)
- `title` (string)
- `image` (string, file path or Steam URL)
- `developer` (string)
- `releaseDate` (date)

#### 📊`GameStat`
الأمر لإنشاء الكيان:  
```bash
php bin/console make:entity GameStat
```
الحقول:
- `id` (int)
- `hoursPlayed` (int)
- `lastPlayed` (datetime_immutable)
- **العلاقات**:
  - `user` → ManyToOne إلى `User`
  - `game` → ManyToOne إلى `Game`

#### 💬`Comment`
الأمر لإنشاء الكيان:  
```bash
php bin/console make:entity Comment
```
الحقول:
- `id` (int)
- `content` (text)
- `createdAt` (datetime_immutable)
- **العلاقات**:
  - `user` → ManyToOne إلى `User`

#### 🔒`UserAuthenticator`
الأمر لإنشاء الكيان:  
```bash
php bin/console make:user
```
الحقول:
- `id` (int)
- `email` (string)
- `roles` (array)
- `password` (string)

---

### إنشاء وتشغيل الترحيلات
- إنشاء الترحيلات:  
  ```bash
  php bin/console make:migration
  ```
- تشغيل الترحيلات:  
  ```bash
  php bin/console doctrine:migrations:migrate
  ```

---

### إنشاء CRUD
لكل كيان، قمت بإنشاء عمليات CRUD باستخدام الأوامر التالية:
```bash
php bin/console make:crud User
php bin/console make:crud Game
php bin/console make:crud GameStat
php bin/console make:crud Comment
```

---