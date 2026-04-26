# Step 1: Use PHP + Apache image
FROM php:8.2-apache

# Step 2: Enable Apache mod_rewrite (for clean URLs)
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

# Step 3: Set the working directory inside container
WORKDIR /var/www/html

# Step 4: Expose Apache port
EXPOSE 80

