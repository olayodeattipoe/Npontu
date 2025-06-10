FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# Copy .env.example to .env and generate application key
RUN cp .env.example .env
RUN php artisan key:generate

# Configure environment for SQLite and create database
RUN mkdir -p /var/www/database
RUN touch /var/www/database/database.sqlite
RUN echo "DB_CONNECTION=sqlite" >> .env
RUN echo "DB_DATABASE=/var/www/database/database.sqlite" >> .env
RUN echo "APP_URL=https://npontu.fly.dev" >> .env
RUN echo "ASSET_URL=https://npontu.fly.dev" >> .env
RUN php artisan migrate --force

# Set permissions
RUN chown -R www-data:www-data /var/www

# Expose port 8080
EXPOSE 8080

# Start PHP-FPM
CMD php artisan serve --host=0.0.0.0 --port=8080 