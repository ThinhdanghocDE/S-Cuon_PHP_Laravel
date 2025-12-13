# S-Cuốn Restaurant E-commerce System

Hệ thống đặt hàng và quản lý nhà hàng S-Cuốn được xây dựng bằng Laravel 8.

## 📋 Yêu cầu hệ thống

Trước khi cài đặt, đảm bảo máy tính của bạn đã cài đặt:

- **PHP**: >= 7.3 hoặc >= 8.0
- **Composer**: Phiên bản mới nhất
- **Node.js**: >= 14.x và npm
- **MySQL**: >= 5.7 hoặc MariaDB >= 10.2
- **Web Server**: Apache hoặc Nginx (hoặc sử dụng Laravel built-in server)
- **Extensions PHP**: 
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath
  - Fileinfo
  - GD hoặc Imagick

## 🐳 Cài đặt với Docker (Khuyến nghị)

Nếu bạn đã cài Docker và Docker Compose, đây là cách nhanh nhất:

```bash
# Clone repository
git clone https://github.com/ThinhdanghocDE/S-Cuon_PHP_Laravel.git
cd S-Cuon_PHP_Laravel

# Khởi động containers
docker-compose up -d

# Chạy script setup tự động
chmod +x docker/start.sh
./docker/start.sh
```

Sau đó truy cập: http://localhost:8000

Xem thêm hướng dẫn chi tiết trong [docker/README.md](docker/README.md)

---

## 🚀 Hướng dẫn cài đặt (Manual)

### Bước 1: Clone repository

```bash
git clone https://github.com/ThinhdanghocDE/S-Cuon_PHP_Laravel.git
cd S-Cuon_PHP_Laravel
```

### Bước 2: Cài đặt dependencies

#### Cài đặt PHP dependencies (Composer)

```bash
composer install
```

#### Cài đặt Node.js dependencies

```bash
npm install
```

### Bước 3: Cấu hình môi trường

#### Tạo file .env

```bash
cp .env.example .env
```

Hoặc nếu không có file `.env.example`, tạo file `.env` mới và copy nội dung từ `env-template.txt`.

#### Cấu hình file .env

Mở file `.env` và cập nhật các thông tin sau:

```env
APP_NAME="S-Cuốn"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### Tạo Application Key

```bash
    php artisan key:generate
```

### Bước 4: Tạo database

#### Nếu chưa có database:

Tạo database MySQL mới:

```sql
CREATE DATABASE your_database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Nếu đã import SQL sẵn:

Bỏ qua bước này và bước 5 (migrations). Chỉ cần đảm bảo file `.env` có đúng thông tin kết nối database.

### Bước 5: Chạy migrations

#### Nếu chưa có database:

Chạy migrations để tạo các bảng trong database:

```bash
php artisan migrate
```

#### Nếu đã import SQL sẵn:

**Bỏ qua bước này** vì database đã có sẵn các bảng và dữ liệu.

### Bước 6: Tạo storage link

Tạo symbolic link cho storage:

```bash
php artisan storage:link
```

### Bước 7: Build assets (tùy chọn)

Nếu bạn muốn compile CSS và JavaScript:

```bash
npm run dev
```

Hoặc cho production:

```bash
npm run production
```

### Bước 8: Chạy server

#### Sử dụng Laravel built-in server:

```bash
php artisan serve
```

Truy cập: `http://localhost:8000`

#### Hoặc sử dụng XAMPP/WAMP:

1. Copy thư mục project vào `htdocs` (XAMPP) hoặc `www` (WAMP)
2. Cấu hình Virtual Host trong Apache
3. Truy cập qua domain đã cấu hình

### Bước 9: Tạo tài khoản Admin (tùy chọn)

#### Nếu chưa có database:

Nếu có seeder cho admin, chạy:

```bash
php artisan db:seed
```

Hoặc tạo tài khoản admin thủ công qua database hoặc form đăng ký.

#### Nếu đã import SQL sẵn:

**Bỏ qua bước này** vì dữ liệu admin đã có sẵn trong database.

---

## 📌 Tóm tắt: Nếu đã import SQL sẵn

Nếu bạn đã import file SQL vào database, bạn có thể **bỏ qua các bước sau**:

- ❌ **Bước 4**: Tạo database (đã có sẵn)
- ❌ **Bước 5**: Chạy migrations (đã có bảng sẵn)
- ❌ **Bước 9**: Chạy seeders (đã có dữ liệu sẵn)

**Chỉ cần thực hiện:**
- ✅ Bước 1-3: Clone, cài dependencies, cấu hình .env
- ✅ Bước 6-8: Storage link, build assets, chạy server

**Lưu ý**: Đảm bảo file `.env` có đúng thông tin kết nối database đã import.

## 📁 Cấu trúc thư mục quan trọng

```
├── app/                    # Application logic
│   ├── Http/Controllers/  # Controllers
│   ├── Models/            # Eloquent Models
│   └── Mail/              # Mail classes
├── database/
│   ├── migrations/        # Database migrations
│   └── seeders/           # Database seeders
├── public/                 # Public assets
│   ├── assets/            # CSS, JS, images
│   └── admin/             # Admin panel assets
├── resources/
│   ├── lang/              # Language files (vi, en)
│   └── views/             # Blade templates
└── routes/
    └── web.php            # Web routes
```

## 🔧 Cấu hình bổ sung

### Cấu hình Email (Gmail)

1. Bật 2-Step Verification trong tài khoản Google
2. Tạo App Password: https://myaccount.google.com/apppasswords
3. Sử dụng App Password trong `MAIL_PASSWORD` của file `.env`

### Cấu hình Permissions (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 🌐 Ngôn ngữ

Hệ thống hỗ trợ:
- Tiếng Việt (vi) - Mặc định
- Tiếng Anh (en)

Các file ngôn ngữ nằm trong `resources/lang/vi/` và `resources/lang/en/`.

## 📝 Database Schema

Các bảng chính:
- `users` - Người dùng
- `products` - Sản phẩm/Món ăn
- `carts` - Giỏ hàng
- `orders` - Đơn hàng
- `reservations` - Đặt bàn
- `chefs` - Đầu bếp
- `banners` - Banner
- `about_us` - Giới thiệu
- `rates` - Đánh giá
- `coupons` - Mã giảm giá
- `charges` - Phí vận chuyển

## 🛠️ Các lệnh Artisan hữu ích

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize
php artisan optimize

# Tạo controller
php artisan make:controller ControllerName

# Tạo model
php artisan make:model ModelName

# Tạo migration
php artisan make:migration create_table_name
```

## 🐛 Xử lý lỗi thường gặp

### Lỗi: "Class 'PDO' not found"
- Cài đặt extension PDO: `sudo apt-get install php-pdo-mysql` (Linux)

### Lỗi: "Permission denied" khi upload file
- Kiểm tra quyền thư mục `storage/` và `public/`

### Lỗi: "No application encryption key"
- Chạy: `php artisan key:generate`

### Lỗi: "SQLSTATE[HY000] [2002] Connection refused"
- Kiểm tra MySQL đã chạy chưa
- Kiểm tra thông tin kết nối trong file `.env`

## 📞 Hỗ trợ

Nếu gặp vấn đề trong quá trình cài đặt, vui lòng:
1. Kiểm tra lại các yêu cầu hệ thống
2. Xem log trong `storage/logs/laravel.log`
3. Tạo issue trên GitHub repository

## 📄 License

MIT License

## 👥 Tác giả

- **ThinhdanghocDE** - [GitHub](https://github.com/ThinhdanghocDE)

---

**Lưu ý**: Đảm bảo file `.env` không được commit lên Git. File này chứa thông tin nhạy cảm như database credentials và API keys.
