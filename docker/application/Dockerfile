FROM php:7.2-apache

ENV DEBIAN_FRONTEND noninteractive

# Configure Apache and installs other services
RUN a2enmod rewrite \
    && service apache2 restart \
    && apt-get update \
    && echo 'ServerName localhost' >> /etc/apache2/apache2.conf \
    && apt-get install -y curl git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install extra php libraries
RUN docker-php-ext-install pdo pdo_mysql

# Add custom Apache config file
ADD docker/application/000-default.conf /etc/apache2/sites-available/000-default.conf

# Add project files
COPY / /var/www/html/application

# Add addition bach script file for configuring Symfony Application
COPY docker/application/run.sh /run.sh
RUN chmod 0755 /run.sh

WORKDIR /var/www/html/application
RUN composer install --no-interaction --ignore-platform-reqs
EXPOSE 80
CMD ["/run.sh"]
