# 📦 Symfony 项目 - Steam 个人资料复刻

---
## 🎯 目标

使用 Symfony（PHP）和 VueJS 创建一个动态网站，复刻个性化的 Steam 用户资料，包括：

### Symfony
- 用户管理（昵称、头像等）✅
- 游戏及其统计信息管理 ✅
- 为 VueJS 提供最小 API ✅
- 干净且关系型的基础结构 ✅

#### 🎯 次要目标
- 以本地化语言显示日期 ✅
- 头像上传功能 ✅
- 用户可根据偏好切换语言 ✅
- 仅管理员可访问 CRUD 页面，增加安全性 ✅

### VueJS
- 使用多个组件 ✅
- 使用路由器 ✅
- 使用 Pinia ✅
- 部分页面通过 Symfony API 动态展示数据 ❌

---

## 🚀 安装

### 🛠️ 先决条件

- PHP 8.1 或更高版本
- Composer
- Symfony CLI
- MySQL 8.0 或更高版本
- Node.js

### 克隆仓库：
```bash
git clone https://github.com/Gaara25/projet_web_steam.git
cd projet_web_steam
```

## 🤝 贡献
欢迎贡献！贡献步骤如下：
- 将您的 fork 与主仓库同步（`git pull origin main`）。
- 为您的功能创建一个分支（`git checkout -b feature/my-feature`）。
- 提交您的更改（`git commit -m "Add my feature"`）。
- 推送您的分支（`git push origin feature/my-feature`）。

---

## 📸 截图

### 首页
![首页](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-home.png?raw=true)

### 用户个人资料
![用户个人资料](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-profile.png?raw=true)

### 管理员 CRUD 界面 
<!-- 我的数据库转储中的密码是 "admin"，电子邮件是 "admin@gmail.com"。 -->
![管理员 CRUD 界面](https://github.com/Gaara25/projet_web_steam/blob/main/public/screenshot/screenshot-admin.png?raw=true)

---

## 🏗️ 设置 Symfony 项目

### 创建项目：
```bash
composer create-project symfony/skeleton projet-steam
```

### 配置 Git：
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/Gaara25/projet_web_steam.git
git branch -M main
git push -u origin main
```

### 项目中使用的依赖：

#### 开发依赖：
```bash
composer require --dev profiler maker
```

#### 生产依赖：
  ```bash
  composer require twig form validator orm asset
  ```
- 以下依赖用于翻译和日期格式化：
  ```bash
  composer require symfony/translation
  composer require symfony/intl
  composer require twig/intl-extra
  ```

- 以下依赖用于安全性：
  ```bash
  composer require symfony/security-bundle
  ```

- 以下依赖用于文件上传：
  ```bash
  composer require vich/uploader-bundle
  ```

- 以下依赖用于设置一个最小 API，使 VueJS 能与 Symfony 后端通信：
  ```bash
  composer require api
  ```

- 以下依赖用于将 Markdown 文本转换为 HTML：
  ```bash
  composer require erusev/parsedown
  ```

### 一些有用的命令：
  
- 启动本地服务器：  
  ```bash
  symfony local:server:start
  ```

- 在 Linux 上启动 MySQL：  
  ```bash
  sudo service mysql start
  ```
  或在 Windows 上：  
  ```bash
  net start mySQL80
  ```

- 管理安全性和用户登录的命令：
  ```bash
  php bin/console security:hash-password
  php bin/console make:security:form-login
  ```

- 创建监听器以根据用户偏好更改语言的 `_locale`：
  ```bash
  php bin/console make:listener LocaleSubscriber
      1. KernelEvents::REQUEST
  ```

---

## 🧱 Symfony 项目结构

### 数据库配置
在 `.env.local` 文件中（需要创建）：
```env
DATABASE_URL="mysql://user:pwd@localhost:3306/DBSteam?serverVersion=8"
```

然后使用以下命令创建数据库：
```bash
php bin/console doctrine:database:create
```

### 创建的实体

#### 🧍‍♂️`User`
生成实体的命令：  
```bash
php bin/console make:entity User
```
字段：
- `id` (int)
- `username` (string)
- `email` (string)
- `avatar` (string, 文件路径)
- `avatarFile` (File, Vich\UploadableField)
- `updatedAt` (datetime_immutable)
- `createdAt` (datetime_immutable)

#### 🎮`Game`
生成实体的命令：  
```bash
php bin/console make:entity Game
```
字段：
- `id` (int)
- `title` (string)
- `image` (string, 文件路径或 Steam URL)
- `developer` (string)
- `releaseDate` (date)

#### 📊`GameStat`
生成实体的命令：  
```bash
php bin/console make:entity GameStat
```
字段：
- `id` (int)
- `hoursPlayed` (int)
- `lastPlayed` (datetime_immutable)
- **关系**：
  - `user` → ManyToOne 到 `User`
  - `game` → ManyToOne 到 `Game`

#### 💬`Comment`
生成实体的命令：  
```bash
php bin/console make:entity Comment
```
字段：
- `id` (int)
- `content` (text)
- `createdAt` (datetime_immutable)
- **关系**：
  - `user` → ManyToOne 到 `User`

#### 🔒`UserAuthenticator`
生成实体的命令：  
```bash
php bin/console make:user
```
字段：
- `id` (int)
- `email` (string)
- `roles` (array)
- `password` (string)

---

### 生成和运行迁移
- 生成迁移：  
  ```bash
  php bin/console make:migration
  ```
- 运行迁移：  
  ```bash
  php bin/console doctrine:migrations:migrate
  ```

---

### 生成 CRUD
为每个实体生成 CRUD 操作的命令：
```bash
php bin/console make:crud User
php bin/console make:crud Game
php bin/console make:crud GameStat
php bin/console make:crud Comment
```

---

## 🏗️ VueJS 项目搭建

- 该依赖用于确保本项目 PHP 和 JavaScript 模块的兼容性。
  ```bash
  composer require symfony/webpack-encore-bundle
  ```

- 安装所需依赖。
  ```bash
  npm install vue-router@4 pinia axios react react-dom prop-types vue-loader@^17.0.0
  ```

---

## 🌱 项目生态设计

### RGAA 审核（通用无障碍改进参考标准）
项目已进行 RGAA 合规性审核：
- **语义结构**：合理使用 HTML 标签（如 `header`、`nav`、`main`、`footer` 等），确保可访问性导航。
- **对比度**：所用颜色符合推荐对比度比例，保证内容可读性。
- **键盘导航**：所有主要功能均可通过键盘访问。
- **文本替代**：图片均有合适的 `alt` 属性。
- **表单**：表单字段均有正确的标签，便于访问。

### RGESN 审核（数字服务生态设计通用参考标准）
RGESN 审核帮助识别并应用多项最佳实践：
- **懒加载**：图片采用延迟加载，减少页面加载时的环境影响。
- **依赖最小化**：前后端仅安装必要的库。
- **缓存管理**：利用浏览器缓存，减少不必要的服务器请求。
- **优化 API**：Symfony 提供的接口仅返回页面展示所需数据，减少数据交换量。

### 已实施的生态设计措施
- **移除未使用资源**：定期清理代码，删除未使用依赖。
- **文档**：在项目文档中强调生态设计，鼓励负责任的未来贡献。

这些措施有助于提升项目的可访问性、性能和数字环境的可持续性。