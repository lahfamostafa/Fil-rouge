# Gestion de terrains sportifs

Application web Laravel pour la réservation de terrains sportifs, la gestion des matchs et la communication entre joueurs et gestionnaires.

## Présentation du projet

Ce projet permet à des clients de réserver des créneaux sur des terrains, à des gestionnaires d’administrer leurs installations et de valider les réservations, et aux utilisateurs de créer des matchs, de demander à participer et d’échanger des annonces.

L’objectif principal est de centraliser la gestion des terrains, des réservations et des rencontres sportives dans une plateforme simple et cohérente.

## Fonctionnalités principales

- Authentification et gestion de profil utilisateur
- Consultation des terrains disponibles et gestion par gestionnaire
- Réservation de créneaux selon les disponibilités
- Validation ou annulation des réservations par le gestionnaire
- Création de matchs à partir d’une réservation
- Demande d’adhésion à un match et validation des participants
- Publication d’annonces et commentaires associés aux matchs
- Gestion des statuts de réservation et de participation

## Technologies utilisées

- PHP 8.2
- Laravel 12
- Blade et Laravel Breeze
- SQLite par défaut
- Vite, Tailwind CSS et Alpine.js
- PHPUnit pour les tests

## Architecture du projet

- `app/Http/Controllers` : logique métier et gestion des routes
- `app/Models` : modèles Eloquent du système
- `routes/` : routes web et routes d’authentification
- `resources/views/` : vues Blade de l’interface
- `database/migrations/` : schéma de base de données
- `tests/` : tests fonctionnels et unitaires

## Prérequis

Avant de démarrer, vérifiez que vous avez installé :

- PHP 8.2 ou supérieur
- Composer
- Node.js et npm
- SQLite

## Installation et configuration

1. Clonez le projet puis placez-vous à la racine :

```bash
git clone <url-du-repo>
cd Fil-rouge
```

2. Installez les dépendances PHP et JavaScript :

```bash
composer install
npm install
```

3. Configurez l’environnement :

```bash
cp .env.example .env
php artisan key:generate
```

4. Vérifiez que le fichier `database/database.sqlite` est présent. La configuration par défaut utilise SQLite.

5. Exécutez les migrations :

```bash
php artisan migrate
```

6. Pour afficher les fichiers uploadés dans le stockage public :

```bash
php artisan storage:link
```

## Lancement du projet

Pour démarrer l’application en mode développement :

```bash
composer run dev
```

Cette commande démarre le serveur Laravel ainsi que les outils front-end de développement. L’application est ensuite accessible via :

```text
http://localhost:8000
```

## Tests

Pour lancer la suite de tests :

```bash
composer run test
```

## Licence

Ce projet est distribué sous licence MIT.
