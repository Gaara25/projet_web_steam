# 📦 مشروع Symfony - استنساخ ملف تعريف Steam

---

## 🎯 الهدف
إنشاء موقع ويب ديناميكي باستخدام Symfony (PHP) وVueJS يحاكي ملف تعريف Steam لمستخدم مخصص مع:

### Symfony
- إدارة المستخدمين (اسم المستخدم، الصورة الرمزية...) ✅
- الألعاب وإحصائيات اللعب ✅
- إنشاء واجهة برمجة تطبيقات (API) بسيطة لـ VueJS ✅
- هيكل أساسي نظيف وعلاقاتي ✅

#### 🎯 هدف ثانوي
- إدارة عرض التواريخ بلغة المستخدم ✅
- رفع الصورة الرمزية ✅
- إمكانية تغيير اللغة حسب تفضيل المستخدم ✅
- إضافة أمان بحيث يمكن للمسؤول فقط رؤية واجهات CRUD ✅

### VueJS
- استخدام عدة مكونات ✅
- استخدام الراوتر ✅
- استخدام pinia ✅
- جزء من الموقع سيستخدم واجهة برمجة التطبيقات الخاصة بـ Symfony لعرض البيانات بشكل ديناميكي. ❌

---

## 🚀 التثبيت

### 🛠️ المتطلبات الأساسية

- PHP 8.1 أو أعلى
- Composer
- Symfony CLI
- MySQL 8.0 أو أعلى
- Node.js

### استنساخ المستودع:
  ```bash
  git clone https://github.com/Gaara25/projet_web_steam.git
  cd projet_web_steam
  ```

## 🤝 المساهمات
المساهمات مرحب بها! للمساهمة:
  - قم بمزامنة الفرع الخاص بك مع المستودع الرئيسي (`git pull origin main`).
  - أنشئ فرعًا لميزتك (`git checkout -b feature/الميزة-الخاصة-بي`).
  - قم بتوثيق تعديلاتك (`git commit -m "إضافة ميزتي"`).
  - ادفع فرعك (`git push origin feature/الميزة-الخاصة-بي`).

---

## 📸 لقطات الشاشة

### الصفحة الرئيسية
![الصفحة الرئيسية](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-home.png?raw=true)

### ملف المستخدم
![ملف المستخدم](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-profile.png?raw=true)

### CRUD في وضع المسؤول 
<!-- كلمة المرور في قاعدة البيانات الخاصة بي هي "admin" والبريد الإلكتروني هو "admin@gmail.com". -->
![واجهة CRUD للمسؤول](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-admin.png?raw=true)

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
  php bin/console make:listener LocaleSubscriber
      1. KernelEvents::REQUEST
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

## 🏗️ إعداد مشروع VuesJS

- هذه التبعية ضرورية لضمان التوافق بين وحدات PHP و JavaScript في هذا المشروع.
  ```bash
  composer require symfony/webpack-encore-bundle
  ```
- تثبيت التبعيات اللازمة.
  ```bash
  npm install vue-router@4 pinia axios react react-dom prop-types vue-loader@^17.0.0
  ```

---

## 🌱 التصميم البيئي للمشروع

### تدقيق RGAA (المعيار العام لتحسين إمكانية الوصول)
تم إجراء تدقيق للتحقق من توافق المشروع مع معيار RGAA:
- **الهيكل الدلالي**: استخدام مناسب لوسوم HTML (`header`، `nav`، `main`، `footer`، إلخ) لضمان سهولة التنقل.
- **التباين**: الألوان المستخدمة تحترم نسب التباين الموصى بها لضمان وضوح المحتوى.
- **التنقل عبر لوحة المفاتيح**: جميع الوظائف الرئيسية يمكن الوصول إليها عبر لوحة المفاتيح.
- **البدائل النصية**: الصور تحتوي على سمات `alt` مناسبة.
- **النماذج**: حقول النماذج موسومة بشكل صحيح وقابلة للوصول.

### تدقيق RGESN (المعيار العام للتصميم البيئي للخدمات الرقمية)
سمح تدقيق RGESN بتحديد وتطبيق عدة ممارسات جيدة:
- **التحميل الكسول (Lazy loading)**: تم تفعيل تحميل الصور عند الحاجة لتقليل الأثر البيئي عند تحميل الصفحات.
- **تقليل التبعيات**: تثبيت المكتبات الضرورية فقط في الواجهة الأمامية والخلفية.
- **إدارة التخزين المؤقت (Cache)**: استخدام التخزين المؤقت للمتصفح للحد من الطلبات غير الضرورية إلى الخادم.
- **واجهة برمجة تطبيقات محسنة**: نقاط النهاية في Symfony ترجع فقط البيانات اللازمة للعرض، مما يقلل من حجم البيانات المتبادلة.

### إجراءات التصميم البيئي المنفذة
- **إزالة الموارد غير المستخدمة**: تنظيف الكود بشكل دوري وحذف التبعيات غير المستعملة.
- **التوثيق**: التوعية بالتصميم البيئي في توثيق المشروع لتشجيع مساهمات مستقبلية مسؤولة.

تساهم هذه الإجراءات في جعل المشروع أكثر سهولة في الوصول، وأداءً أفضل، وأكثر احترامًا للبيئة الرقمية.