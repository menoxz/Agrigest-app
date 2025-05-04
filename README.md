# AGRIGEST - Gestion Agricole

![Version](https://img.shields.io/badge/version-1.0.0-green)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![Laravel](https://img.shields.io/badge/Laravel-10.x-red)

## À propos d'Agrigest

Agrigest est une application web de gestion agricole qui permet aux agriculteurs de suivre leurs parcelles, planifier leurs interventions et optimiser leur productivité. L'application offre une interface intuitive et des fonctionnalités avancées pour une gestion complète des exploitations agricoles.

## Fonctionnalités principales

### Interface Agriculteur
- **Gestion des parcelles** : Création, modification et suppression de parcelles avec informations détaillées
- **Cartographie** : Visualisation des parcelles sur une carte interactive grâce à Leaflet.js
- **Gestion des interventions** : Planification et suivi des opérations sur les parcelles
- **Suivi des imprévus** : Enregistrement des événements non planifiés affectant les cultures
- **Statistiques** : Analyse détaillée des activités et performances
- **Rapports PDF** : Génération de rapports d'interventions par parcelle

### Interface Administrateur
- **Tableau de bord** : Vue d'ensemble des statistiques globales du système
- **Gestion des utilisateurs** : Ajout, modification, désactivation des comptes
- **Gestion des types de cultures** : Configuration des cultures disponibles
- **Gestion des types d'interventions** : Définition des types d'opérations agricoles
- **Paramètres système** : Configuration globale de l'application

## Structure technique

### Architecture
- Application basée sur **Laravel 10** avec une architecture MVC
- Base de données **MySQL 8.0** pour le stockage des données
- **Docker** pour l'environnement de développement et de déploiement
- **Tailwind CSS** pour le design responsive
- **Leaflet.js** pour les fonctionnalités cartographiques
- **Livewire** pour les composants dynamiques
- **DomPDF** pour la génération de rapports PDF

### Structure des données
- **Utilisateurs** : Comptes agriculteurs et administrateurs avec rôles distincts
- **Parcelles** : Unités agricoles avec géolocalisation
- **Types de cultures** : Catalogue des cultures disponibles
- **Interventions** : Opérations planifiées sur les parcelles
- **Types d'interventions** : Catalogue des opérations possibles
- **Imprévus** : Événements non planifiés liés aux interventions

## Installation

### Prérequis
- Docker et Docker Compose
- PHP 8.2 ou supérieur
- Composer
- Node.js et NPM

### Procédure d'installation

1. Cloner le dépôt
```bash
git clone https://github.com/votre-repo/agrigest.git
cd agrigest
```

2. Copier le fichier d'environnement
```bash
cp .env.example .env
```

3. Démarrer les conteneurs Docker
```bash
docker-compose up -d
```

4. Installer les dépendances
```bash
docker exec agrigest-app composer install
docker exec agrigest-app npm install
```

5. Générer la clé d'application
```bash
docker exec agrigest-app php artisan key:generate
```

6. Exécuter les migrations et les seeders
```bash
docker exec agrigest-app php artisan migrate --seed
```

7. Compiler les assets
```bash
docker exec agrigest-app npm run build
```

8. Accéder à l'application : http://localhost:8000

## Utilisation

### Agriculteur
- Connexion avec identifiants agriculteur
- Création de parcelles et ajout de leurs coordonnées géographiques
- Planification d'interventions sur les parcelles
- Consultation des statistiques de l'exploitation
- Génération de rapports PDF par parcelle

### Administrateur
- Connexion avec identifiants administrateur (admin@example.com / password)
- Gestion des utilisateurs et attribution des rôles
- Configuration des types de cultures et d'interventions
- Analyse des statistiques globales du système

## Tests

L'application inclut des tests fonctionnels et unitaires :

```bash
docker exec agrigest-app php artisan test
```

## Problèmes courants et solutions

### Connexion à la base de données
Si vous rencontrez des problèmes de connexion à la base de données, vérifiez :
- Que les conteneurs Docker sont bien démarrés
- Que les variables d'environnement dans le fichier .env sont correctes
- Que le service MySQL est accessible via le port 3306

### Affichage des cartes
Pour que les cartes fonctionnent correctement :
- Les coordonnées (latitude, longitude) doivent être correctement renseignées
- Une connexion internet est nécessaire pour charger les tuiles OpenStreetMap
- Le JavaScript doit être activé dans le navigateur

## Fonctionnalités à venir

- Export des données au format CSV/Excel
- Interface mobile responsive
- Analyse prédictive des rendements
- Intégration avec des capteurs IoT pour le suivi en temps réel
- Module de gestion des stocks d'intrants

## Contributeurs

- Lux-Tech
- GEKEMA
- Veronique04
- Isaacmazamesso

