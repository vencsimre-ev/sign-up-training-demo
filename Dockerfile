# ---------------------------------------
# STAGE 1
# Desc:         Composer dependencies install
# Type:         required
# Stage type:   intermediate
# ---------------------------------------
    FROM composer:2.6 AS php_builder
    WORKDIR /app
    COPY . . 
    RUN composer install --optimize-autoloader --no-progress --no-interaction --ignore-platform-reqs
    
# ---------------------------------------
# STAGE 2
# Desc:         Base PHP-Apache Image
# Type:         required
# ---------------------------------------
    FROM php:8.2-apache
    
    ARG UID=1000
    ARG GID=1000
    
    WORKDIR /var/www/html
    
    # Install dependencies and extensions
    RUN apt-get update && apt-get install -y \
        zip unzip git \
        && apt-get clean
    
    ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
    RUN chmod +x /usr/local/bin/install-php-extensions \
        && install-php-extensions pdo_mysql redis imagick intl zip
    
    # Enable Apache modules and set server name
    RUN a2enmod rewrite proxy proxy_http
    RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
    
    # Configure PHP production settings
    RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
    
    # Adjust www-data user/group IDs
    RUN groupmod -g $GID www-data && usermod -o -u $UID www-data
    
    # Copy Composer binary from the builder stage
    COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer
    
    # Copy configuration files
    COPY ./.docker/php-apache/custom.ini /usr/local/etc/php/conf.d/custom.ini
    COPY ./.docker/php-apache/vhost.conf /etc/apache2/sites-available/000-default.conf
    
    # Copy application files
    COPY --chown=www-data:www-data . .
    COPY --chown=www-data:www-data --from=php_builder /app/vendor /var/www/html/vendor
    