# Oshop
back-PHP

# Projet de Cours, en cours de développement - Site de Vente de Chaussures BACK

Ce projet a été réalisé dans le cadre d'un cours en PHP et se concentre sur la création du backend d'un site de vente de chaussures. Le projet utilise Altorouter pour la gestion des routes et suit le modèle MVC (Modèle-Vue-Contrôleur) pour organiser le code.

## Fonctionnalités

- Mise en place des routes avec Altorouter pour gérer la navigation dans l'application.
- Utilisation du modèle MVC pour organiser le code de manière structurée et modulaire.
- Contrôleurs dédiés pour la gestion des catégories et des produits permettant de réaliser le CRUD.
- Utilisation de modèles pour interagir avec la base de données MySQL.
- Mise de place d'un Controller spécifique à la connexion et de déconexion , enregistrée en session.
  

## Structure du Projet

Le projet est organisé de la manière suivante :

- **`app`**: Contient les contrôleurs, les modèles, les vues et d'autres fichiers spécifiques à l'application.
- **`public`**: Répertoire public accessible via le navigateur. Contient le fichiers des Routes.


## Configuration

1. **Configuration de la Base de Données** : Assurez-vous de configurer les paramètres de connexion à la base de données dans le fichier `app/config/database.php` et avec le fichier config.ini.

2. **Dépendances** : Exécutez `composer install` pour installer les dépendances définies dans le fichier `composer.json`.

## Utilisation

1. Clonez le projet : `git clone https://github.com/SandrineJAHAN/Oshop.git`
2. Installez les dépendances : `composer install`
3. Configurez la base de données : Modifiez les paramètres dans `app/config/database.php`
4. Démarrez un serveur PHP local : `php -S localhost:8000 -t public`

Le site sera accessible à l'adresse [http://localhost:8000](http://localhost:8000).

## Contribuer

Si vous souhaitez contribuer au projet, n'hésitez pas à ouvrir une pull request. Toutes les contributions sont les bienvenues !
