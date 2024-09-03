FROM php:8.3-fpm

RUN apt-get update \

    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql \
    && apt-get install -y nginx \

COPY nginx/default.conf /etc/nginx/conf.d/default.conf
COPY . /var/www/html
RUN nginx -t
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html
EXPOSE 80
CMD ["sh", "-c", "/usr/local/sbin/php-fpm && service nginx start"]

