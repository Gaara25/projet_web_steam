# 📦 Symfony 프로젝트 - Steam 프로필 재현

---

## 🎯 목표
Symfony(PHP)와 VueJS를 사용하여 사용자의 Steam 프로필을 재현하는 동적 웹사이트를 만듭니다.

### Symfony
- 사용자 관리(닉네임, 아바타 등) ✅
- 게임 및 게임 통계 관리 ✅
- VueJS를 위한 최소 API 구현 ✅
- 깔끔하고 관계형 기반 구조 ✅

#### 🎯 부가 목표
- 날짜를 현지 언어로 표시 ✅
- 아바타 업로드 기능 ✅
- 사용자의 선호 언어에 따라 언어 변경 가능 ✅
- 관리자만 CRUD를 볼 수 있도록 보안 추가 ✅

### VueJS
- 여러 컴포넌트 사용 ✅
- 라우터 사용 ✅
- Pinia 사용 ✅
- 사이트 일부는 Symfony API를 통해 동적으로 데이터를 표시 ❌

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

## 🏗️ VueJS 프로젝트 설정

- 이 종속성은 PHP와 JavaScript 모듈 간의 호환성을 보장하기 위해 필요합니다.
  ```bash
  composer require symfony/webpack-encore-bundle
  ```

- 필요한 종속성 설치.
  ```bash
  npm install vue-router@4 pinia axios react react-dom prop-types vue-loader@^17.0.0
  ```

---

## 🌱 프로젝트 에코디자인

### RGAA(웹 접근성 일반 기준) 감사
프로젝트가 RGAA 기준을 준수하는지 확인하기 위해 감사를 실시했습니다:
- **시맨틱 구조**: 접근 가능한 내비게이션을 보장하기 위해 적절한 HTML 태그(`header`, `nav`, `main`, `footer` 등) 사용
- **명암비**: 가독성을 보장하기 위해 권장 명암비를 준수
- **키보드 내비게이션**: 모든 주요 기능은 키보드로 접근 가능
- **텍스트 대체**: 이미지에 적절한 `alt` 속성 제공
- **폼**: 폼 필드는 올바르게 라벨링되고 접근 가능

### RGESN(디지털 서비스 에코디자인 일반 기준) 감사
RGESN 감사를 통해 여러 모범 사례를 식별하고 적용했습니다:
- **지연 로딩**: 페이지 로딩 시 환경 영향을 줄이기 위해 이미지 지연 로딩 적용
- **의존성 최소화**: 프론트엔드와 백엔드에 필요한 라이브러리만 설치
- **캐시 관리**: 불필요한 서버 요청을 줄이기 위해 브라우저 캐시 사용
- **최적화된 API**: Symfony가 제공하는 엔드포인트는 화면 표시를 위해 필요한 데이터만 반환하여 데이터 전송량 최소화

### 적용된 에코디자인 조치
- **불필요한 리소스 제거**: 코드 정리 및 사용하지 않는 의존성 정기적으로 삭제
- **문서화**: 프로젝트 문서에서 에코디자인에 대한 인식 제고, 책임 있는 미래 기여 장려

이러한 조치는 프로젝트를 더욱 접근성 높고, 성능이 뛰어나며, 디지털 환경을 존중하는 방향으로 만듭니다.