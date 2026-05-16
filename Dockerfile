FROM php:8.2-apache

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

RUN apt-get update && apt-get install -y \
    libgd-dev libzip-dev libpng-dev libjpeg-dev \
    libicu-dev libonig-dev libxml2-dev \
    && docker-php-ext-install gd zip pdo pdo_mysql bcmath intl mbstring xml

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . .

RUN composer install --optimize-autoloader --no-scripts --no-interaction
RUN npm install && npm run build

RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

CMD ["sh", "-c", "sed -i \"s/80/${PORT}/g\" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf && php artisan config:clear && php artisan migrate --force && apache2-foreground"]