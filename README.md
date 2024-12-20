# Gestion des Événements Sportifs

Une application Symfony pour gérer des événements sportifs, afficher les participants, et calculer les distances entre les utilisateurs et les lieux d'événements.

## Fonctionnalités

- Créer, afficher, et gérer des événements sportifs.
- Ajouter des participants à des événements.
- Calculer les distances entre un utilisateur et un événement.
- Affichage interactif des lieux sur une carte via Leaflet.
- Interface utilisateur moderne avec Tailwind CSS.

---

### Auteur et Date

- **Auteur :** Pierre Crepin  
- **Date de création :** Décembre 2024  
- **Dernière mise à jour :** Décembre 2024

---

## Prérequis

Assurez-vous d'avoir les outils suivants installés sur votre machine :

- PHP >= 8.1
- Composer
- Node.js et npm
- Symfony CLI
- Un serveur de base de données (MySQL)

---

## Installation

### Étape 1 : Cloner le projet

```bash
git clone https://github.com/Pierrecrp1/Symfony_reservation_app/settings/access
cd nom-du-repo
```

### Étape 2 : Installer les dépendances backend

```bash
composer install
```

### Étape 3 : Configurer la base de données

1. Configurez les informations de connexion à votre base de données dans `.env` :

   ```env
   DATABASE_URL="mysql://<user>:<password>@127.0.0.1:3306/<nom_base>"
   ```

2. Créez la base de données :

   ```bash
   php bin/console doctrine:database:create
   ```

3. Appliquez les migrations pour générer les tables :

   ```bash
   php bin/console doctrine:migrations:migrate
   ```

4. Ajoutez les données de test (fixtures) :

   ```bash
   php bin/console doctrine:fixtures:load
   ```

### Étape 4 : Installer les dépendances frontend

```bash
npm install
npm run build:css
```

---

## Prise en main

### Lancer le serveur Symfony

Démarrez le serveur Symfony pour accéder à l'application :

```bash
symfony server:start
```

### Accéder à l'application

- Ouvrez votre navigateur à l'adresse : [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## Fonctionnalités clés

### 1. Gérer les événements

- Accédez à la page **Liste des événements** pour voir tous les événements.
- Cliquez sur **Créer un événement** pour ajouter un nouvel événement.
- Accédez aux détails d'un événement pour voir ses informations et ses participants.

### 2. Ajouter des participants

Depuis la page de détails d'un événement, cliquez sur **Ajouter un participant** pour associer un participant à cet événement.

### 3. Calculer les distances

- Entrez vos coordonnées (latitude et longitude) dans les champs dédiés sur la page de liste des événements ou la page de détails.
- L'application calcule automatiquement la distance entre vous et les événements.

### 4. Cartes interactives

Sur la page de détails, une carte interactive affiche l'emplacement de l'événement.

---

## Technologies utilisées

- **Symfony 7.2** : Framework backend PHP.
- **Doctrine ORM** : Gestion de la base de données.
- **Twig** : Moteur de templates.
- **Leaflet** : Cartes interactives pour afficher les lieux.
- **Tailwind CSS** : Framework CSS pour un design moderne et réactif.
