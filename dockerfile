# -------- STAGE 1: BUILD --------
FROM php:8.2-cli AS builder

RUN apt-get update && apt-get install -y \
    curl git unzip libpq-dev libzip-dev libicu-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_pgsql zip intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar apenas dependências (para cache)
COPY composer.json composer.lock package*.json ./

# Instalar dependências sem scripts (evita erro do artisan)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Instalar dependências frontend
RUN npm install

# Agora copiar o resto do projeto
COPY . .

# Executar scripts do Laravel (agora já existe artisan)
RUN php artisan package:discover

# Build frontend (Vite)
RUN npm run build

# -------- STAGE 2: RUNTIME --------
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev libzip-dev libicu-dev zip unzip \
    && docker-php-ext-install pdo pdo_pgsql zip intl opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Apache configurado para Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && a2enmod rewrite

# OpCache (performance)
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/html

# Copiar aplicação do builder
COPY --from=builder /app /var/www/html

# Permissões seguras
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copiar entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
CMD ["apache2-foreground"]