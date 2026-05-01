# Step 1: Base image
FROM php:8.2-apache

# Step 2: Install required extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Step 3: Enable Apache rewrite
RUN a2enmod rewrite

# Step 4: Set working directory
WORKDIR /var/www/html

# Step 5: Copy project files into container
# COPY . /var/www/html

# Step 5: ONLY copy actual app
COPY ./first_project/ /var/www/html

# Step 6: Set permissions (IMPORTANT)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Step 7: Expose port
EXPOSE 80