# Docker Setup cho S-Cuốn Restaurant E-commerce System

Hướng dẫn sử dụng Docker để chạy project S-Cuốn.

## 📋 Yêu cầu

- Docker >= 20.10
- Docker Compose >= 2.0

## 🚀 Cách sử dụng

### 1. Khởi động containers

```bash
docker-compose up -d
```

### 2. Chạy script setup tự động (Khuyến nghị)

#### Nếu chưa có database:

```bash
chmod +x docker/start.sh
./docker/start.sh
```

#### Nếu đã import SQL sẵn:

```bash
chmod +x docker/start.sh
./docker/start.sh --skip-migrations
# hoặc
./docker/start.sh -s
```

Script này sẽ tự động:
- Cài đặt Composer dependencies
- Cài đặt NPM dependencies
- Tạo file .env nếu chưa có
- Generate application key
- Chạy migrations (bỏ qua nếu dùng `--skip-migrations`)
- Tạo storage link
- Set permissions
- Clear caches

### 3. Hoặc setup thủ công

#### Cài đặt dependencies

```bash
# Composer
docker-compose exec app composer update --with-all-dependencies

# NPM
docker-compose exec app npm install
```

#### Tạo file .env

```bash
cp .env.example .env
# Hoặc
cp env-template.txt .env
```

#### Generate application key

```bash
docker-compose exec app php artisan key:generate
```

#### Chạy migrations

**Chỉ chạy nếu chưa import SQL:**

```bash
docker-compose exec app php artisan migrate
```

**Nếu đã import SQL sẵn, bỏ qua bước này.**

#### Tạo storage link

```bash
docker-compose exec app php artisan storage:link
```

#### Set permissions

```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

## 🌐 Truy cập

- **Application**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080

## 🗄️ Thông tin Database

- **Host**: `db` (trong container) hoặc `localhost:3306` (từ máy host)
- **Database**: `restaurant_db`
- **Username**: `root`
- **Password**: `root`
- **User**: `restaurant_user` (nếu cần)

## 📝 Các lệnh hữu ích

### Xem logs

```bash
# Tất cả services
docker-compose logs -f

# Chỉ app
docker-compose logs -f app

# Chỉ nginx
docker-compose logs -f nginx

# Chỉ database
docker-compose logs -f db
```

### Chạy Artisan commands

```bash
docker-compose exec app php artisan [command]
```

Ví dụ:
```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan tinker
```

### Chạy Composer commands

```bash
docker-compose exec app composer [command]
```

### Chạy NPM commands

```bash
docker-compose exec app npm [command]
```

### Truy cập vào container

```bash
# Vào container app
docker-compose exec app bash

# Vào container db
docker-compose exec db bash
```

### Dừng containers

```bash
docker-compose down
```

### Dừng và xóa volumes (xóa database)

```bash
docker-compose down -v
```

### Rebuild containers

```bash
docker-compose build --no-cache
docker-compose up -d
```

## 🔧 Cấu hình

### Thay đổi port

Sửa file `docker-compose.yml`:

```yaml
nginx:
  ports:
    - "8000:80"  # Thay đổi 8000 thành port bạn muốn
```

### Thay đổi MySQL credentials

Sửa file `docker-compose.yml`:

```yaml
db:
  environment:
    MYSQL_DATABASE: restaurant_db
    MYSQL_ROOT_PASSWORD: root
    MYSQL_PASSWORD: root
    MYSQL_USER: restaurant_user
```

Và cập nhật file `.env` tương ứng.

### Thay đổi PHP settings

Sửa file `docker/php/local.ini`:

```ini
upload_max_filesize=40M
post_max_size=40M
memory_limit=256M
```

Sau đó rebuild container:

```bash
docker-compose build app
docker-compose up -d app
```

## 📌 Trường hợp đã import SQL sẵn

Nếu bạn đã import file SQL vào database, bạn có thể:

### Option 1: Sử dụng flag `--skip-migrations`

```bash
./docker/start.sh --skip-migrations
```

### Option 2: Setup thủ công và bỏ qua migrations

Khi setup thủ công, **bỏ qua lệnh migrate**:

```bash
# Cài đặt dependencies
docker-compose exec app composer install
docker-compose exec app npm install

# Tạo .env và generate key
cp .env.example .env
docker-compose exec app php artisan key:generate

# ⚠️ BỎ QUA: docker-compose exec app php artisan migrate

# Tạo storage link
docker-compose exec app php artisan storage:link

# Set permissions
docker-compose exec app chmod -R 775 storage bootstrap/cache

# Clear caches
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
```

**Lưu ý**: Đảm bảo file `.env` có đúng thông tin kết nối database đã import.

---

## 🐛 Xử lý lỗi

### Lỗi: "Permission denied"

```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### Lỗi: "Connection refused" với database

Kiểm tra MySQL đã sẵn sàng:

```bash
docker-compose exec db mysqladmin ping -h localhost
```

### Lỗi: Port đã được sử dụng

Thay đổi port trong `docker-compose.yml` hoặc dừng service đang sử dụng port đó.

### Clear tất cả caches

```bash
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan view:clear
docker-compose exec app php artisan route:clear
```

## 📦 Services

- **app**: PHP 8.0-FPM với các extensions cần thiết
- **nginx**: Web server
- **db**: MySQL 8.0
- **phpmyadmin**: Quản lý database (tùy chọn)

## 🔒 Bảo mật

⚠️ **Lưu ý**: Cấu hình mặc định chỉ dùng cho development. 

Cho production:
- Thay đổi MySQL root password
- Sử dụng environment variables cho sensitive data
- Tắt phpMyAdmin hoặc bảo vệ bằng authentication
- Cấu hình SSL/TLS
- Sử dụng secrets management

