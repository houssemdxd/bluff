# Use PHP 8.2 FPM base image
FROM php:8.2-fpm

# Install required packages and PHP extensions
RUN apt update \
    && apt install -y \
        zlib1g-dev \
        g++ \
        git \
        libicu-dev \
        zip \
        libzip-dev \
        supervisor \
        curl \
        unzip \
        default-mysql-client \
    && docker-php-ext-install intl opcache pdo pdo_mysql zip \
    && pecl install apcu \
    && docker-php-ext-enable apcu

# Set working directory
WORKDIR /var/www/symfony_docker

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Create Supervisor directories
RUN mkdir -p /etc/supervisor/conf.d /var/log/supervisor

# Copy Supervisor configuration
COPY supervisord.conf /etc/supervisor/supervisord.conf

# Copy and set up startup script
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Use the startup script as the container's command
CMD ["/usr/local/bin/start.sh"]
