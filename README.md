# 🏥 Rendu Projet API – Clinique Vétérinaire

Bienvenue dans ce projet Symfony permettant de gérer une clinique vétérinaire.

## 🚀 Installation
1. Cloner le projet
``` git clone git@github.com:alyssialopr/API-platform.git```

2. Entrer dans le projet
``` cd API-platform ```

3. Installer les dépendances afin d'avoir un projet fonctionnel
```composer install```

## 📌 Utilisation
Une fois le projet installé

1. Démarrer l'application
```symfony serve```

2. Ouvrir le navigateur et aller sur 
```http://localhost:8000/api```

## 🔎 Fonctionnalité de recherche
Afin que les vétérinaires, assistants et directeur puissent voir les rendez-vous par dates voici comment faire : 

### Recherche par date du jour : 
```https://127.0.0.1:8000/api/appointments?apDate[after]=2025-03-22T00:00:00&apDate[before]=2025-03-22T23:59:59```

### Recherche par date sur une période :
```https://127.0.0.1:8000/api/appointments?apDate[after]=2025-01-01&apDate[strictly_before]=2025-12-12```

## 👥 Membres du projet
* [Léora CHRIQUI](https://github.com/Leoratz) 
* [Alyssia LORSOLD PRADON](https://github.com/alyssialopr)
