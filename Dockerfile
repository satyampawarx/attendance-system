FROM php:8.2-apache

# Install PostgreSQL extension
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql

# Copy project files
COPY . /var/www/html/

# Enable Apache rewrite
RUN a2enmod rewrite

EXPOSE 80

# ---------------------------------------------------------------
# DB credentials ata image madhe bake naka. Run karताna pass kara:
#
#   docker run -p 80:80 \
#     -e DB_HOST=your-host \
#     -e DB_PORT=5432 \
#     -e DB_NAME=attendance \
#     -e DB_USER=your-user \
#     -e DB_PASSWORD=your-password \
#     -e DB_SSLMODE=require \
#     your-image-name
#
# Kiwa .env file + docker-compose.yml vaparun sudha karta yeईल.
# ---------------------------------------------------------------
