FROM php:8.3-fpm-bullseye

# Install system dependencies and security updates
RUN apt-get update && apt-get upgrade -y && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install bcmath

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . /var/www

# Change ownership of our applications
RUN chown -R www-data:www-data /var/www

# Change current user to www-data
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"] 