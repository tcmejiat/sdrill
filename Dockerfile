
FROM php:8.1-apache
RUN docker-php-ext-install mysqli
COPY html/ /var/www/html/
EXPOSE 80
