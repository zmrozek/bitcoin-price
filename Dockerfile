# Vyberte oficiální obraz PHP s Apache
FROM php:8-apache

# Aktualizace balíčků a instalace závislostí
RUN apt-get update && apt-get upgrade -y && \
    apt-get install -y git unzip libzip-dev && \
    docker-php-ext-install zip

# Nainstalujte Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Povolte potřebné rozšíření PHP pro Symfony
RUN docker-php-ext-install pdo_mysql opcache

# Nastavení Apache pro Symfony
RUN a2enmod rewrite

# Kopírování konfiguračního souboru Apache pro Symfony
COPY ./docker/apache/symfony.conf /etc/apache2/sites-available/000-default.conf

# Nastavení pracovního adresáře
WORKDIR /var/www/html
