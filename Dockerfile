FROM php:8.2-fpm

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Nettoyage du cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation des extensions PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définition du répertoire de travail
WORKDIR /var/www

# Copie des fichiers du projet
COPY . /var/www

# Attribution des permissions et configuration de Git pour le conteneur
RUN chown -R www-data:www-data /var/www
RUN git config --global --add safe.directory /var/www

# Note: On n'installe PAS Breeze dans le Dockerfile car cela crée des problèmes en mode non-interactif
# Breeze sera installé via une commande après le démarrage du conteneur

# Exposition du port 9000
EXPOSE 9000

# Démarrage de PHP-FPM
CMD ["php-fpm"]
