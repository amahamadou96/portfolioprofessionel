# Portfolio - Dockerfile
# Déploiement Docker avec Apache et PHP

FROM php:8.1-apache

# Activer les modules Apache nécessaires
RUN a2enmod rewrite \
    && a2enmod headers \
    && a2enmod deflate

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install -j$(nproc) \
    mysqli \
    pdo \
    pdo_mysql

# Copier les fichiers du portfolio
COPY . /var/www/html/

# Donner les permissions correctes
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/ \
    && chmod -R 775 /var/www/html/logs/ \
    && chmod -R 775 /var/www/html/uploads/

# Copier la configuration Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Exposer le port
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
