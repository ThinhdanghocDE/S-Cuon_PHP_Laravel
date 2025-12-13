#!/bin/bash

# Check if --skip-migrations flag is set
SKIP_MIGRATIONS=false
if [[ "$1" == "--skip-migrations" ]] || [[ "$1" == "-s" ]]; then
    SKIP_MIGRATIONS=true
    echo "ℹ️  Skipping migrations (database already imported)"
fi

echo "🚀 Starting S-Cuốn Restaurant E-commerce System..."

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
until docker-compose exec -T db mysqladmin ping -h localhost --silent; do
    echo "MySQL is unavailable - sleeping"
    sleep 2
done

echo "✅ MySQL is ready!"

# Install Composer dependencies
echo "📦 Installing Composer dependencies..."
docker-compose exec -T app composer install --no-interaction --prefer-dist --optimize-autoloader

# Install NPM dependencies
echo "📦 Installing NPM dependencies..."
docker-compose exec -T app npm install

# Generate application key if not exists
if [ ! -f .env ]; then
    echo "📝 Creating .env file..."
    cp .env.example .env 2>/dev/null || cp env-template.txt .env
    docker-compose exec -T app php artisan key:generate
fi

# Run migrations (skip if flag is set)
if [ "$SKIP_MIGRATIONS" = false ]; then
    echo "🗄️  Running database migrations..."
    docker-compose exec -T app php artisan migrate --force
else
    echo "⏭️  Skipping migrations (database already imported)"
fi

# Create storage link
echo "🔗 Creating storage link..."
docker-compose exec -T app php artisan storage:link

# Set permissions
echo "🔐 Setting permissions..."
docker-compose exec -T app chmod -R 775 storage bootstrap/cache

# Clear caches
echo "🧹 Clearing caches..."
docker-compose exec -T app php artisan config:clear
docker-compose exec -T app php artisan cache:clear
docker-compose exec -T app php artisan view:clear
docker-compose exec -T app php artisan route:clear

echo "✅ Setup complete!"
echo ""
echo "🌐 Application: http://localhost:8000"
echo "🗄️  phpMyAdmin: http://localhost:8080"
echo ""
echo "📝 Default MySQL credentials:"
echo "   Host: localhost:3306"
echo "   Database: restaurant_db"
echo "   Username: root"
echo "   Password: root"

