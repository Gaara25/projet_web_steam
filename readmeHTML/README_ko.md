# 📦 Symfony 프로젝트 - Steam 프로필 재현

---

## 🎯 목표
Symfony (PHP)와 VueJS를 사용하여 개인화된 Steam 사용자 프로필을 재현하는 동적 웹사이트를 생성합니다:
- 사용자 관리 (사용자 이름, 아바타 등) ✅
- 게임 및 게임 통계 ✅
- VueJS를 위한 최소 API 구현 ✅
- 깔끔하고 관계형 데이터베이스 구조 ✅

### 🎯 부가 목표
- 유지 관리 언어로 날짜 표시 관리 ✅
- 아바타 업로드 ✅
- 사용자가 선호하는 언어로 변경할 수 있도록 허용 ✅
- 관리자만 CRUD 작업에 접근할 수 있도록 보안 추가 ✅

---

## 🚀 설치

### 🛠️ 사전 요구 사항

- PHP 8.1 이상
- Composer
- Symfony CLI
- MySQL 8.0 이상
- Node.js

### 저장소 클론:
```bash
git clone https://github.com/Gaara25/projet_web_steam.git
cd projet_web_steam
```

## 🤝 기여
기여는 언제나 환영입니다! 기여하려면:
- 포크한 저장소를 메인 저장소와 동기화하세요 (`git pull origin main`).
- 기능을 위한 브랜치를 생성하세요 (`git checkout -b feature/my-feature`).
- 변경 사항을 커밋하세요 (`git commit -m "Add my feature"`).
- 브랜치를 푸시하세요 (`git push origin feature/my-feature`).

---

## 📸 스크린샷

### 홈 페이지
![홈 페이지](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-home.png?raw=true)

### 사용자 프로필
![사용자 프로필](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-profile.png?raw=true)

### 관리자 CRUD 인터페이스 
<!-- 내 덤프의 비밀번호는 "admin"이고 이메일은 "admin@gmail.com"입니다. -->
![관리자 CRUD 인터페이스](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-admin.png?raw=true)

---

## 🏗️ Symfony 프로젝트 설정

### 프로젝트 생성:
```bash
composer create-project symfony/skeleton projet-steam
```

### Git 구성:
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/Gaara25/projet_web_steam.git
git branch -M main
git push -u origin main
```

### 프로젝트에서 사용된 종속성:

#### 개발 종속성:
```bash
composer require --dev profiler maker
```

#### 프로덕션 종속성:
  ```bash
  composer require twig form validator orm asset
  ```
- 번역 및 날짜 형식화를 위한 종속성:
  ```bash
  composer require symfony/translation
  composer require symfony/intl
  composer require twig/intl-extra
  ```

- 보안을 위한 종속성:
  ```bash
  composer require symfony/security-bundle
  ```

- 파일 업로드를 위한 종속성:
  ```bash
  composer require vich/uploader-bundle
  ```

- Symfony 백엔드와 VueJS 간의 통신을 위한 최소 API 설정 종속성:
  ```bash
  composer require api
  ```

- Markdown 텍스트를 HTML로 변환하기 위한 종속성:
  ```bash
  composer require erusev/parsedown
  ```

### 유용한 명령어:
  
- 로컬 서버 시작:  
  ```bash
  symfony local:server:start
  ```

- Linux에서 MySQL 시작:  
  ```bash
  sudo service mysql start
  ```
  또는 Windows에서:  
  ```bash
  net start mySQL80
  ```

- 보안 및 사용자 로그인 관리를 위한 명령어:
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- 사용자의 선호 언어에 따라 `_locale`을 변경하는 리스너 생성 명령어:
  ```bash
  php bin/console make:listener LocaleSubscriber
      1. KernelEvents::REQUEST
  ```

---

## 🧱 Symfony 프로젝트 구조

### 데이터베이스 구성
`.env.local` 파일에서 (생성 필요):
```env
DATABASE_URL="mysql://user:pwd@localhost:3306/DBSteam?serverVersion=8"
```

그런 다음, 다음 명령어로 데이터베이스 생성:
```bash
php bin/console doctrine:database:create
```

### 생성된 엔티티

#### 🧍‍♂️`User`
엔티티 생성 명령어:  
```bash
php bin/console make:entity User
```
필드:
- `id` (int)
- `username` (string)
- `email` (string)
- `avatar` (string, 파일 경로)
- `avatarFile` (File, Vich\UploadableField)
- `updatedAt` (datetime_immutable)
- `createdAt` (datetime_immutable)

#### 🎮`Game`
엔티티 생성 명령어:  
```bash
php bin/console make:entity Game
```
필드:
- `id` (int)
- `title` (string)
- `image` (string, 파일 경로 또는 Steam URL)
- `developer` (string)
- `releaseDate` (date)

#### 📊`GameStat`
엔티티 생성 명령어:  
```bash
php bin/console make:entity GameStat
```
필드:
- `id` (int)
- `hoursPlayed` (int)
- `lastPlayed` (datetime_immutable)
- **관계**:
  - `user` → `User`에 대한 ManyToOne
  - `game` → `Game`에 대한 ManyToOne

#### 💬`Comment`
엔티티 생성 명령어:  
```bash
php bin/console make:entity Comment
```
필드:
- `id` (int)
- `content` (text)
- `createdAt` (datetime_immutable)
- **관계**:
  - `user` → `User`에 대한 ManyToOne

#### 🔒`UserAuthenticator`
엔티티 생성 명령어:  
```bash
php bin/console make:user
```
필드:
- `id` (int)
- `email` (string)
- `roles` (array)
- `password` (string)

---

### 마이그레이션 생성 및 실행
- 마이그레이션 생성:  
  ```bash
  php bin/console make:migration
  ```
- 마이그레이션 실행:  
  ```bash
  php bin/console doctrine:migrations:migrate
  ```

---

### CRUD 생성
각 엔티티에 대해 다음 명령어로 CRUD 작업을 생성했습니다:
```bash
php bin/console make:crud User
php bin/console make:crud Game
php bin/console make:crud GameStat
php bin/console make:crud Comment
```

---