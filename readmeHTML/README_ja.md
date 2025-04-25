# 📦 Symfonyプロジェクト - Steamプロフィール再現

---

## 🎯 目的
Symfony (PHP) と VueJS を使用して、パーソナライズされた Steam ユーザープロフィールを再現する動的なウェブサイトを作成する:
- ユーザー管理 (ユーザー名、アバターなど) ✅
- ゲームとゲーム統計 ✅
- VueJS 用の最小限の API の実装 ❌
- クリーンでリレーショナルなデータベース構造 ✅

### 🎯 副次的な目的
- 表示される日付を選択された言語で管理 ✅
- アバターのアップロード ✅
- ユーザーが言語を選択して変更できるようにする ✅
- 管理者のみが CRUD 操作にアクセスできるようにセキュリティを追加 ✅

---

## 🏗️ Symfonyプロジェクトのセットアップ

### プロジェクト作成:
```bash
composer create-project symfony/skeleton projet-steam
```

### Gitの設定:
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/Gaara25/projet_web_steam.git
git branch -M main
git push -u origin main
```

### プロジェクト全体で使用される依存関係:

#### 開発用依存関係:
```bash
composer require --dev profiler maker
```

#### 本番用依存関係:
  ```bash
  composer require twig form validator orm asset
  ```
- 翻訳と日付フォーマットに必要な依存関係:
  ```bash
  composer require symfony/translation
  composer require symfony/intl
  composer require twig/intl-extra
  ```

- セキュリティに必要な依存関係:
  ```bash
  composer require symfony/security-bundle
  ```

- ファイルアップロードに使用される依存関係:
  ```bash
  composer require vich/uploader-bundle
  ```

- SymfonyバックエンドとVueJS間の通信を可能にする最小限のAPIを設定するための依存関係:
  ```bash
  composer require api
  ```

- MarkdownテキストをHTMLに変換するための依存関係:
  ```bash
  composer require erusev/parsedown
  ```

### 便利なコマンド:
  
- ローカルサーバーを起動する:  
  ```bash
  symfony local:server:start
  ```

- LinuxでMySQLを起動する:  
  ```bash
  sudo service mysql start
  ```
  またはWindowsで:  
  ```bash
  net start mySQL80
  ```

- セキュリティとユーザーログインを管理するコマンド:
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- ユーザーの選択に基づいて言語を変更するために`_locale`を変更するリスナーを作成するコマンド:
  ```bash
  php bin/console make:listener
  ```

---

## 🧱 Symfonyプロジェクト構造

### データベース設定
`.env.local`ファイル (作成する必要あり):
```env
DATABASE_URL="mysql://user:pwd@localhost:3306/DBSteam?serverVersion=8"
```

次に、以下のコマンドでデータベースを作成:
```bash
php bin/console doctrine:database:create
```

### 作成されたエンティティ

#### 🧍‍♂️`User`
エンティティを生成するコマンド:  
```bash
php bin/console make:entity User
```
フィールド:
- `id` (int)
- `username` (string)
- `email` (string)
- `avatar` (string, ファイルパス)
- `avatarFile` (File, Vich\UploadableField)
- `updatedAt` (datetime_immutable)
- `createdAt` (datetime_immutable)

#### 🎮`Game`
エンティティを生成するコマンド:  
```bash
php bin/console make:entity Game
```
フィールド:
- `id` (int)
- `title` (string)
- `image` (string, ファイルパスまたはSteam URL)
- `developer` (string)
- `releaseDate` (date)

#### 📊`GameStat`
エンティティを生成するコマンド:  
```bash
php bin/console make:entity GameStat
```
フィールド:
- `id` (int)
- `hoursPlayed` (int)
- `lastPlayed` (datetime_immutable)
- **リレーション**:
  - `user` → `User`へのManyToOne
  - `game` → `Game`へのManyToOne

#### 💬`Comment`
エンティティを生成するコマンド:  
```bash
php bin/console make:entity Comment
```
フィールド:
- `id` (int)
- `content` (text)
- `createdAt` (datetime_immutable)
- **リレーション**:
  - `user` → `User`へのManyToOne

#### 🔒`UserAuthenticator`
エンティティを生成するコマンド:  
```bash
php bin/console make:user
```
フィールド:
- `id` (int)
- `email` (string)
- `roles` (array)
- `password` (string)

---

### マイグレーションの生成と実行
- マイグレーションを生成:  
  ```bash
  php bin/console make:migration
  ```
- マイグレーションを実行:  
  ```bash
  php bin/console doctrine:migrations:migrate
  ```

---

### CRUDの生成
各エンティティに対して、以下のコマンドでCRUD操作を生成:
```bash
php bin/console make:crud User
php bin/console make:crud Game
php bin/console make:crud GameStat
php bin/console make:crud Comment
```

---