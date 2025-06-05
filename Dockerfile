FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    mariadb-server \
    zlib1g-dev \
    libpng-dev \
    && docker-php-ext-install gd pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

COPY ./web/ /var/www/html
RUN chmod -R 755 /var/www/html && \
    chown -R www-data:www-data /var/www/html

COPY ./database.sql /docker-entrypoint-initdb.d/
COPY ./entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
