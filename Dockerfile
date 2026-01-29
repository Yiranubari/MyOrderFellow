# Use the official PHP image with Apache
FROM php:8.2-apache

# 1. Install development packages and dependencies
# We need libpq-dev to compile the Postgres extension
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# 2. Install the PHP extensions for PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# 3. Enable Apache mod_rewrite (Crucial for your .htaccess router)
RUN a2enmod rewrite

# 4. Set the working directory
WORKDIR /var/www/html

# 5. Copy your application code to the container
COPY . /var/www/html/

# 6. Configure Apache to allow .htaccess overrides
# This ensures your routing logic works
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# 7. Set permissions (Optional but good practice)
RUN chown -R www-data:www-data /var/www/html