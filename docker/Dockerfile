FROM php:8.2-apache

# Installer extensions PHP nécessaires pour MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activer mod_rewrite (utile plus tard)
RUN a2enmod rewrite

# Donner les bons droits
RUN chown -R www-data:www-data /var/www/html
