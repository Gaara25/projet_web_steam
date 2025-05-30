# 📦 Symfonyプロジェクト - Steamプロフィール再現

---

## 🎯 目的
Symfony (PHP) と VueJS を使用して、パーソナライズされた Steam ユーザープロフィールを再現する動的なウェブサイトを作成する:
- ユーザー管理 (ユーザー名、アバターなど) ✅
- ゲームとゲーム統計 ✅
- VueJS 用の最小限の API の実装 ✅
- クリーンでリレーショナルなデータベース構造 ✅

### 🎯 副次的な目的
- 表示される日付を選択された言語で管理 ✅
- アバターのアップロード ✅
- ユーザーが言語を選択して変更できるようにする ✅
- 管理者のみが CRUD 操作にアクセスできるようにセキュリティを追加 ✅

---

## 🚀 インストール

### 🛠️ 必要条件

- PHP 8.1 以上
- Composer
- Symfony CLI
- MySQL 8.0 以上
- Node.js

### リポジトリをクローン:
```bash
git clone https://github.com/Gaara25/projet_web_steam.git
cd projet_web_steam
```

## 🤝 コントリビューション
コントリビューションは歓迎します！コントリビューションするには:
- フォークしたリポジトリをメインリポジトリと同期する (`git pull origin main`)。
- 機能用のブランチを作成する (`git checkout -b feature/my-feature`)。
- 変更をコミットする (`git commit -m "Add my feature"`)。
- ブランチをプッシュする (`git push origin feature/my-feature`)。

---

## 📸 スクリーンショット

### ホームページ
![ホームページ](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-home.png?raw=true)

### ユーザープロフィール
![ユーザープロフィール](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-profile.png?raw=true)

### 管理者CRUDインターフェース 
<!-- ダンプ内のパスワードは "admin"、メールアドレスは "admin@gmail.com" です。 -->
![管理者CRUDインターフェース](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-admin.png?raw=true)

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
  php bin/console make:listener LocaleSubscriber
      1. KernelEvents::REQUEST
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

## 🏗️ VueJSプロジェクトのセットアップ

- この依存関係は、PHPモジュールとJavaScriptモジュール間の互換性を確保するために必要です。
  ```bash
  composer require symfony/webpack-encore-bundle
  ```

- 必要な依存関係のインストール。
  ```bash
  npm install vue-router@4 pinia axios react react-dom prop-types vue-loader@^17.0.0
  ```

---

## 🌱 プロジェクトのエコデザイン

### RGAA監査（アクセシビリティ向上のための一般基準）
プロジェクトがRGAAに準拠しているかどうかを確認するために監査を実施しました:
- **セマンティック構造**: アクセシブルなナビゲーションを保証するために、適切なHTMLタグ（`header`、`nav`、`main`、`footer`など）を使用。
- **コントラスト**: 使用されている色は、コンテンツの可読性を確保するために推奨されるコントラスト比を満たしています。
- **キーボードナビゲーション**: すべての主要な機能はキーボードでアクセス可能です。
- **代替テキスト**: 画像には適切な`alt`属性が付与されています。
- **フォーム**: フォームフィールドは正しくラベル付けされ、アクセシブルです。

### RGESN監査（デジタルサービスのエコデザイン一般基準）
RGESN監査により、いくつかのベストプラクティスを特定し、適用しました:
- **遅延読み込み**: ページ読み込み時の環境負荷を軽減するために画像の遅延読み込みを実装。
- **依存関係の最小化**: フロントエンドとバックエンドの両方で必要なライブラリのみをインストール。
- **キャッシュ管理**: 不要なサーバーリクエストを減らすためにブラウザキャッシュを利用。
- **最適化されたAPI**: Symfonyが公開するエンドポイントは、表示に必要なデータのみを返し、データ転送量を削減。

### 実施したエコデザインアクション
- **未使用リソースの削除**: コードの定期的なクリーンアップと未使用依存関係の削除。
- **ドキュメント**: プロジェクトのドキュメントでエコデザインへの配慮を促し、今後の責任ある貢献を推奨。

これらのアクションにより、プロジェクトはよりアクセシブルでパフォーマンスが高く、デジタル環境に配慮したものとなっています。