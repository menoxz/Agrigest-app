# Guide d'installation d'Agrigest

Ce guide détaille les étapes nécessaires pour installer et configurer l'application Agrigest sur un environnement de développement ou de production.

## Prérequis

Avant de commencer l'installation, assurez-vous que votre système dispose des éléments suivants :

- **Docker** et **Docker Compose** (Pour l'environnement conteneurisé)
- **Git** (Pour cloner le dépôt)
- **PHP 8.2** ou supérieur (Pour l'exécution locale si nécessaire)
- **Composer** (Pour la gestion des dépendances PHP)
- **Node.js** et **NPM** (Pour la compilation des assets front-end)

## Installation avec Docker (Recommandée)

### 1. Clonage du dépôt

```bash
git clone https://github.com/votre-repo/agrigest.git
cd agrigest
```

### 2. Configuration de l'environnement

Copiez le fichier d'environnement exemple et configurez-le selon vos besoins :

```bash
cp .env.example .env
```

Modifiez les paramètres de connexion à la base de données et autres configurations si nécessaire.

### 3. Démarrage des conteneurs Docker

```bash
docker-compose up -d
```

Cette commande démarre tous les services nécessaires (PHP, MySQL, Nginx, Redis, PHPMyAdmin).

### 4. Installation des dépendances

```bash
docker exec agrigest-app composer install
docker exec agrigest-app npm install
```

### 5. Configuration de l'application

Générez la clé d'application :

```bash
docker exec agrigest-app php artisan key:generate
```

Exécutez les migrations pour créer la structure de la base de données :

```bash
docker exec agrigest-app php artisan migrate
```

Remplissez la base de données avec les données de départ :

```bash
docker exec agrigest-app php artisan db:seed
```

### 6. Compilation des assets

```bash
docker exec agrigest-app npm run build
```

### 7. Accès à l'application

L'application est maintenant accessible à l'adresse : http://localhost:8000

PHPMyAdmin est disponible à l'adresse : http://localhost:8080 (identifiants dans le fichier .env)

## Installation sans Docker (Alternative)

Si vous préférez ne pas utiliser Docker, voici les étapes pour une installation directe :

### 1. Clonage du dépôt

```bash
git clone https://github.com/votre-repo/agrigest.git
cd agrigest
```

### 2. Configuration de l'environnement

```bash
cp .env.example .env
```

Modifiez les paramètres de connexion à la base de données pour qu'ils pointent vers votre installation MySQL locale :

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agrigest
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

### 3. Installation des dépendances

```bash
composer install
npm install
```

### 4. Configuration de l'application

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### 5. Compilation des assets

```bash
npm run build
```

### 6. Démarrage du serveur de développement

```bash
php artisan serve
```

L'application sera accessible à l'adresse : http://localhost:8000

## Comptes par défaut

Après l'installation et le seeding de la base de données, vous pouvez vous connecter avec les comptes suivants :

### Administrateur
- **Email** : admin@example.com
- **Mot de passe** : Password123!

### Agriculteur
- **Email** : agriculteur@example.com
- **Mot de passe** : Password123!

## Dépannage

### Problèmes de connexion à la base de données

Si vous rencontrez des problèmes de connexion à la base de données, vérifiez :
- Que les services Docker sont bien démarrés : `docker-compose ps`
- Que les informations de connexion dans le fichier .env sont correctes
- L'accessibilité de la base de données : `docker exec agrigest-db mysql -u root -p`

### Problèmes de permissions

Si vous rencontrez des problèmes de permissions lors de l'exécution des commandes artisan :
```bash
docker exec agrigest-app chmod -R 777 storage bootstrap/cache
```

### Erreur "Class not found"

Si vous rencontrez des erreurs "Class not found" après l'installation ou la mise à jour des dépendances :
```bash
docker exec agrigest-app composer dump-autoload
```

## Mise à jour de l'application

Pour mettre à jour l'application vers la dernière version :

```bash
git pull
docker exec agrigest-app composer install
docker exec agrigest-app php artisan migrate
docker exec agrigest-app npm install
docker exec agrigest-app npm run build
```

## Environnement de production

Pour un déploiement en production, n'oubliez pas de modifier le fichier .env :

```
APP_ENV=production
APP_DEBUG=false
```

Et d'optimiser l'application :

```bash
docker exec agrigest-app php artisan config:cache
docker exec agrigest-app php artisan route:cache
docker exec agrigest-app php artisan view:cache
``` 
