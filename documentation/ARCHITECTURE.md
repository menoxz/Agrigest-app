# Architecture Technique d'Agrigest

Ce document présente l'architecture technique du projet Agrigest, une application de gestion agricole développée avec Laravel.

## Vue d'ensemble

Agrigest est structuré selon le pattern MVC (Modèle-Vue-Contrôleur) proposé par Laravel, avec une séparation claire des responsabilités :

```
Agrigest
├── App/                  # Code source de l'application
│   ├── Http/             # Couche HTTP (Controllers, Middleware, Requests)
│   ├── Models/           # Modèles de données
│   ├── Providers/        # Service providers
│   ├── Rules/            # Règles de validation personnalisées
│   └── View/             # Composants de vue
├── bootstrap/            # Fichiers de démarrage Laravel
├── config/               # Configuration de l'application
├── database/             # Migrations et seeders
├── public/               # Point d'entrée et assets compilés
├── resources/            # Assets non compilés et vues
├── routes/               # Définitions des routes
├── storage/              # Fichiers générés par l'application
└── tests/                # Tests automatisés
```

## Pile technologique

- **Backend** : PHP 8.2, Laravel 10.x
- **Frontend** : Blade, Tailwind CSS, JavaScript, Alpine.js
- **Base de données** : MySQL 8.0
- **Environnement** : Docker, Nginx
- **Cache** : Redis
- **Cartographie** : Leaflet.js
- **Génération PDF** : DomPDF
- **Composants dynamiques** : Livewire

## Modèles et relations

Le schéma de base de données d'Agrigest s'articule autour des entités suivantes :

### User
- Représente un utilisateur du système (agriculteur ou administrateur)
- Relations :
  - `role()` : Appartient à un rôle
  - `parcelles()` : Possède plusieurs parcelles
  - `interventions()` : A réalisé plusieurs interventions
  - `typeCultures()` : A créé plusieurs types de cultures

### Role
- Définit les rôles disponibles dans l'application
- Relations :
  - `users()` : Possède plusieurs utilisateurs

### Parcelle
- Représente une unité de terrain agricole
- Relations :
  - `user()` : Appartient à un utilisateur
  - `typeCulture()` : Associée à un type de culture
  - `interventions()` : Possède plusieurs interventions

### TypeCulture
- Définit les différents types de cultures disponibles
- Relations :
  - `parcelles()` : Associé à plusieurs parcelles
  - `user()` : Créé par un utilisateur

### Intervention
- Représente une opération agricole planifiée sur une parcelle
- Relations :
  - `parcelle()` : Associée à une parcelle
  - `typeIntervention()` : Définit le type d'intervention
  - `user()` : Réalisée par un utilisateur
  - `imprevus()` : Possède plusieurs imprévus

### TypeIntervention
- Définit les différents types d'interventions possibles
- Relations :
  - `interventions()` : Associé à plusieurs interventions
  - `user()` : Créé par un utilisateur

### Imprevu
- Représente un événement non planifié lié à une intervention
- Relations :
  - `intervention()` : Associé à une intervention

## Système d'authentification et d'autorisation

### Authentification
Agrigest utilise le système d'authentification natif de Laravel avec des extensions personnalisées :
- Login/Register standard avec validation d'email
- Vérification du statut utilisateur à chaque requête
- Redirection conditionnelle basée sur le rôle après connexion

### Autorisation
L'autorisation est gérée à plusieurs niveaux :
- **Niveau route** : Middleware `admin` pour protéger les routes administratives
- **Niveau contrôleur** : Méthodes d'autorisation (ex: `authorizeParcelle()`)
- **Niveau vue** : Affichage conditionnel des éléments basé sur le rôle

## Architecture des contrôleurs

Les contrôleurs sont organisés par domaine fonctionnel :

### AdminController
Gère l'interface d'administration avec des méthodes pour :
- Dashboard administrateur
- Gestion des utilisateurs
- Supervision des parcelles, interventions et imprévus
- Configuration des types de cultures et d'interventions

### ParcelleController
Gère les parcelles des agriculteurs avec des fonctionnalités de :
- Création et édition de parcelles
- Affichage cartographique
- Vérification d'autorisation propriétaire

### InterventionController
Gère les interventions agricoles avec :
- Planification et suivi des interventions
- Association avec les parcelles et types d'interventions

### ImprevuController
Gère les imprévus liés aux interventions avec :
- Enregistrement des événements imprévus
- Association avec les interventions existantes

### StatistiqueController
Génère les statistiques d'exploitation avec :
- Analyse des parcelles et interventions
- Calcul des indicateurs de performance

### RapportController
Génère les rapports PDF avec :
- Synthèse des interventions par parcelle
- Historique des opérations

## Système de cartographie

Le système de cartographie est basé sur Leaflet.js et permet :
- Affichage des parcelles sur une carte interactive
- Visualisation d'une parcelle spécifique ou de toutes les parcelles
- Affichage des détails de la parcelle au clic
- Gestion de l'absence de coordonnées géographiques

## Architecture Docker

L'environnement de développement est conteneurisé avec Docker Compose, comprenant :
- **agrigest-app** : Conteneur PHP pour l'application
- **agrigest-nginx** : Serveur web Nginx
- **agrigest-db** : Base de données MySQL
- **agrigest-redis** : Cache Redis
- **agrigest-phpmyadmin** : Interface de gestion de base de données

## Tests

L'application est testée à plusieurs niveaux :
- **Tests unitaires** : Validant les modèles et leurs relations
- **Tests fonctionnels** : Validant les contrôleurs et leurs actions
- **Tests d'authentification** : Validant le système de connexion et autorisation

## Architecture front-end

Le front-end est construit avec :
- **Blade** : Moteur de template Laravel
- **Tailwind CSS** : Framework CSS utilitaire
- **Alpine.js** : Framework JavaScript léger pour interactions dynamiques
- **Livewire** : Framework pour composants dynamiques sans écrire de JavaScript

## Optimisations de performance

Plusieurs stratégies d'optimisation sont implémentées :
- Eager loading des relations pour éviter le problème N+1
- Cache des résultats de requêtes fréquentes
- Pagination des résultats pour les grandes collections
- Lazy loading des images pour optimiser le chargement initial

## Sécurité

Les mesures de sécurité incluent :
- Protection CSRF sur tous les formulaires
- Validation des entrées utilisateur côté serveur
- Échappement automatique des sorties dans Blade
- Autorisations strictes pour l'accès aux données
- Authentification basée sur les sessions avec protection avancée 
