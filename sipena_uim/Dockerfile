FROM dunglas/frankenphp:php8.2

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

RUN apt-get update && apt-get install -y \
    libgd-dev libzip-dev libpng-dev libjpeg-dev \
    libicu-dev libonig-dev libxml2-dev \
    && docker-php-ext-install gd zip pdo pdo_mysql bcmath intl mbstring xml

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .

RUN composer install --optimize-autoloader --no-scripts --no-interaction
RUN npm install && npm run build

RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

# Copy Caddyfile custom
COPY Caddyfile /etc/caddy/Caddyfile

ENV SERVER_NAME=":8000"

CMD ["sh", "-c", "php artisan config:clear && php artisan migrate --force && frankenphp run --config /etc/caddy/Caddyfile"]