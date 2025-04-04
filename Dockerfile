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

# Installation de Node.js et NPM (nécessaires pour Laravel Breeze)
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Définition du répertoire de travail
WORKDIR /var/www

# Copie des fichiers du projet
COPY . /var/www

# Attribution des permissions et configuration de Git pour le conteneur
RUN chown -R www-data:www-data /var/www
RUN git config --global --add safe.directory /var/www

# Installation de Laravel Breeze et configuration de l'authentification
# On installe Breeze APRÈS avoir configuré les routes pour éviter les erreurs
RUN composer require laravel/breeze --dev --no-scripts
# On génère les contrôleurs d'authentification et les vues
RUN php artisan breeze:install blade --no-interaction
RUN npm install
RUN npm run build
# On exécute les scripts composer post-install après avoir tout configuré
RUN composer dump-autoload

# Installation de Laravel Breeze
RUN composer require laravel/breeze --dev
RUN php artisan breeze:install
RUN npm install
RUN npm run build

# Exposition du port 9000
EXPOSE 9000

# Démarrage de PHP-FPM
CMD ["php-fpm"]
