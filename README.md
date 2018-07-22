Investor
===================

# Description

Cette plateforme permet de participer au financement de grands projets.

La page d'accueil affiche les projets disponibles et leur état d'avancement.
Pour investir il est nécessaire de se connecter. 

Pour cela, deux utilisateurs sont disponibles : 

| email           | password | Role       | API token                        |
| ----------------|----------|------------|----------------------------------|
| john@local.com  | john     | ROLE_USER  | d60d8cef3e639757b70c08b56797e771 |
| admin@local.com | admin    | ROLE_ADMIN | 49a4bc6558987a595efbac4ada1e1021 |

Une fois connecté en temps que simple utilisateur (`ROLE_USER`) il est possible d'investir dans un projet.
Les administrateurs (`ROLE_ADMIN`) ont accès à un back office leur permettant d'ajouter, modifier et supprimer les projets.

# Installation
- ```composer install```
- ```composer init-db ```

# API

Une API est accessible pour lister tous les projets et investir.
Pour avoir accès à l'API il suffit de s'authentifier avec un *token* comme dans l'exemple :

```/api/projects?apitoken=myultrasecureapitoken```

### Lister les projets

Afficher la liste de tous les projets avec leur état d'avancement.
 
`/api/projects`

### Investir

Investir dans un projet

`/api/invest`

Les paramètres suivants sont nécessaire pour investir dans un projet :

| clé         | type            | exemple |
|-------------|-----------------|---------|
| project_id  | `integer`       | 2       |
| amount      | `integer`       | 100000  |
