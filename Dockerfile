# Myshope — Laravel 11 + PHP 8.2 pour Render
# Build: docker build -t myshope .
# Run local: docker run -p 8080:80 --env-file .env myshope

# ---------- Étape 1 : assets Vite ----------
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund
COPY resources resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

# ---------- Étape 2 : dépendances PHP ----------
# Base PHP 8.2 (même version que prod) + Composer : évite les mismatch de platform
FROM php:8.2-cli AS vendor
RUN apt-get update && apt-get install -y --no-install-recommends git curl zip unzip libzip-dev \
 && docker-php-ext-install zip \
 && apt-get clean && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-plugins --no-scripts --prefer-dist --optimize-autoloader --ignore-platform-reqs

# ---------- Étape 3 : image finale ----------
FROM php:8.2-apache

# Extensions requises : MySQL (local/XAMPP) + Postgres (Render) + GD/ZIP pour uploads
RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
 && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip \
 && a2enmod rewrite \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Apache : DocumentRoot = public/. Le port $PORT est injecté au démarrage
# par docker-entrypoint.sh (Apache ne comprend pas ${PORT:-80}).
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
 && printf 'Listen 80\n' > /etc/apache2/ports.conf \
 && printf '<VirtualHost *:80>\n\tDocumentRoot ${APACHE_DOCUMENT_ROOT}\n\t<Directory ${APACHE_DOCUMENT_ROOT}>\n\t\tAllowOverride All\n\t\tRequire all granted\n\t</Directory>\n\tErrorLog ${APACHE_LOG_DIR}/error.log\n\tCustomLog ${APACHE_LOG_DIR}/access.log combined\n</VirtualHost>\n' > /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# Code applicatif
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

# Permissions Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

# Entrypoint : migrations + cache + démarrage Apache
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80
ENTRYPOINT ["docker-entrypoint.sh"]
