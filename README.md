Voici une version plus concise et structurée de votre documentation pour le **README** :

---

# CarRentalAPI - Documentation

## Contexte du projet

Le projet **CarRentalAPI** a pour objectif de développer une **API REST** pour la gestion des locations de voitures. L'API sera utilisée pour automatiser les processus de réservation, paiement et gestion des utilisateurs dans l’industrie de la mobilité.

## Objectifs

- Créer une API REST robuste avec **Laravel**.
- Gérer l'authentification via **Laravel Sanctum**.
- Implémenter des opérations CRUD pour les voitures et les utilisateurs.
- Ajouter des fonctionnalités de validation des données et de gestion des erreurs.
- Intégrer la pagination et les filtres pour une meilleure gestion des données.
- Rédiger la documentation API avec **Swagger**.

## Fonctionnalités principales

- **Gestion des voitures** : CRUD pour les voitures (création, affichage, mise à jour, suppression).
- **Gestion des utilisateurs** : Authentification et gestion des utilisateurs.
- **Location et paiement** : Gestion des réservations et des paiements.
- **Pagination** : Pagination des résultats pour les voitures.
- **Validation des données** : Validation des données d’entrée.

## Architecture

- **Modèles principaux** : `User`, `Car`, `Rental`, `Payment`.
- **Routes** : CRUD pour les voitures et utilisateurs, gestion des locations et paiements.
- **Contrôleurs** : Séparation des responsabilités avec des contrôleurs RESTful.

## Technologies

- **Laravel** : Framework PHP pour la création de l’API.
- **Sanctum** : Pour l’authentification et l’autorisation des utilisateurs.
- **Swagger (Laravel OpenAPI)** : Documentation automatique de l’API.
- **Postman** : Pour tester les endpoints de l’API.

## Installation

1. Clonez le dépôt :
   ```bash
   git clone <repo-url>
   ```

2. Installez les dépendances :
   ```bash
   composer install
   ```

3. Configurez votre fichier `.env` pour les paramètres de base de données.

4. Exécutez les migrations :
   ```bash
   php artisan migrate
   ```

5. Démarrez le serveur :
   ```bash
   php artisan serve
   ```

## Authentification

Utilisez **Laravel Sanctum** pour l'authentification via token.

1. Créez un utilisateur via l’endpoint `/api/register`.
2. Obtenez un token d’authentification via `/api/login`.
3. Incluez ce token dans les en-têtes pour accéder aux ressources protégées.

## Documentation API

La documentation complète de l'API est générée via **Swagger**. Vous pouvez y accéder à l'URL suivante :  
[Swagger Documentation](http://localhost:8000/api/documentation)

## Tests

Les tests peuvent être effectués avec **Postman** en utilisant les endpoints fournis. Le projet inclut des tests pour chaque endpoint afin de vérifier leur bon fonctionnement.

