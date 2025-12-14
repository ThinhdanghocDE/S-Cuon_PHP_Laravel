# Base image PHP-FPM
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# -------------------------------
# 1️⃣ Install system dependencies
# -------------------------------
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# -------------------------------
# 2️⃣ Install Node.js (for Mix/Vite)
# -------------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# -------------------------------
# 3️⃣ Install Composer
# -------------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# -------------------------------
# 4️⃣ Copy Laravel application
# -------------------------------
COPY . /var/www/html

# -------------------------------
# 5️⃣ Set permissions
# -------------------------------
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# -------------------------------
# 6️⃣ Expose port and run PHP-FPM
# -------------------------------
EXPOSE 9000

# Run PHP-FPM in foreground, listen TCP
CMD ["php-fpm", "-F", "-R"]
