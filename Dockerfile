# Dockerfile

FROM php:8.1-apache

# Install any required extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pgsql

# Enable Apache mod_rewrite, if needed
RUN a2enmod rewrite

# Copy your app into the container (or rely on volumes in docker-compose)
COPY ./src /var/www/html

# Expose port 80 (optional, Docker Compose does it anyway)
EXPOSE 80

# By default, the container will run Apache in the foreground
CMD ["apache2-foreground"]