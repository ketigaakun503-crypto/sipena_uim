FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libgd-dev libzip-dev libpng-dev libjpeg-dev \
    && docker-php-ext-install gd zip pdo pdo_mysql bcmath intl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .
RUN composer install --optimize-autoloader --no-scripts --no-interaction
RUN npm install && npm run build

EXPOSE $PORT
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
