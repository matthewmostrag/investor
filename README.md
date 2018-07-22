Investor
===================

# Description

Cette plateforme permet de participer au financement de grands projets.

La page d'accueil affiche les projets disponibles et leur état d'avancement.
Pour investir il est nécessaire de se connecter. 

Pour cela, deux utilisateurs sont disponibles : 

| email     | password    | Role |
| ----------|-------------|--------|
| john@local.com  | john   | ROLE_USER    |
| admin@local.com | admin | ROLE_ADMIN   | 

Une fois connecté en temps que simple utilisateur (`ROLE_USER`) il est possible d'investir dans un projet.
Les administrateurs (`ROLE_ADMIN`) ont accès à un back office leur permettant d'ajouter, modifier et supprimer les projets.

# Installation
- ```composer install```
- ```composer init-db ```
