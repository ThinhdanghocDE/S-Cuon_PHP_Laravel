# Restaurant E-commerce System

A comprehensive restaurant e-commerce platform built with Laravel 8, featuring online ordering, reservation management, payment integration, and an administrative dashboard for managing products, orders, users, and content.

## System Requirements

Before installation, ensure your system has the following prerequisites:

- PHP: >= 7.3 or >= 8.0
- Composer: Latest version
- Node.js: >= 14.x and npm
- MySQL: >= 5.7 or MariaDB >= 10.2
- Web Server: Apache or Nginx (or Laravel built-in server)

Required PHP Extensions:
- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- BCMath
- Fileinfo
- GD or Imagick

## Installation

### Option 1: Docker Installation (Recommended)

If you have Docker and Docker Compose installed, this is the fastest setup method:

```bash
# Clone repository
git clone https://github.com/ThinhdanghocDE/S-Cuon_PHP_Laravel.git
cd S-Cuon_PHP_Laravel

# Start containers
docker-compose up -d

# Run setup script
chmod +x docker/start.sh
./docker/start.sh
```

Access the application at: http://localhost:8000

For detailed Docker setup instructions, see [docker/README.md](docker/README.md)

### Option 2: Manual Installation

#### Step 1: Clone Repository

```bash
git clone https://github.com/ThinhdanghocDE/S-Cuon_PHP_Laravel.git
cd S-Cuon_PHP_Laravel
```

#### Step 2: Install Dependencies

Install PHP dependencies using Composer:

```bash
composer install
```

Install Node.js dependencies:

```bash
npm install
```

#### Step 3: Environment Configuration

Create the `.env` file:

```bash
cp .env.example .env
```

If `.env.example` does not exist, create a new `.env` file and copy content from `env-template.txt`.

Configure the `.env` file with the following settings:

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

Generate application key:

```bash
php artisan key:generate
```

#### Step 4: Database Setup

If you need to create a new database:

```sql
CREATE DATABASE your_database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

If you have already imported an SQL file:

```bash
php artisan migrate
```

If you have already imported an SQL file:

Skip this step as the database already contains tables and data.

#### Step 6: Create Storage Link

Create a symbolic link for storage:

```bash
php artisan storage:link
```

#### Step 7: Build Assets (Optional)

To compile CSS and JavaScript for development:

```bash
npm run dev
```

For production:

```bash
npm run production
```

#### Step 8: Start Development Server

Using Laravel built-in server:

```bash
php artisan serve
```

Access the application at: `http://localhost:8000`

Using XAMPP/WAMP:

1. Copy the project directory to `htdocs` (XAMPP) or `www` (WAMP)
2. Configure Virtual Host in Apache
3. Access via the configured domain

#### Step 9: Create Admin Account (Optional)
username: vuthinh122004@gmail.com
password: Vuthinh_hd123

```bash
php artisan db:seed
```


## Project Structure

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

## Additional Configuration

### Email Configuration (Gmail)

1. Enable 2-Step Verification in your Google account
2. Create an App Password: https://myaccount.google.com/apppasswords
3. Use the App Password in `MAIL_PASSWORD` in your `.env` file

### File Permissions (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Useful Artisan Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize application
php artisan optimize

# Create controller
php artisan make:controller ControllerName

# Create model
php artisan make:model ModelName

# Create migration
php artisan make:migration create_table_name
```

## Features

- Online menu browsing and product catalog
- Shopping cart with guest checkout support
- Order placement and tracking
- Payment gateway integration (VNPay)
- Table reservation system
- Admin dashboard for content management
- User authentication with two-factor authentication
- Responsive design
- Performance optimization with caching

## License

MIT License

## Author

**ThinhdanghocDE** - [GitHub](https://github.com/ThinhdanghocDE)

