# Configuration Docker avec phpMyAdmin

## Prérequis

- Docker et Docker Compose installés
- Git (pour cloner le projet)

## Configuration

### 1. Créer le fichier .env

Créez un fichier `back/.env` avec le contenu suivant :

```env
# Database configuration for MySQL
DATABASE_URL="mysql://app:!ChangeMe!@database:3306/concert_booking?serverVersion=8.0&charset=utf8mb4"

# MySQL environment variables
MYSQL_DATABASE=concert_booking
MYSQL_ROOT_PASSWORD=root
MYSQL_USER=app
MYSQL_PASSWORD=!ChangeMe!

# Symfony configuration
APP_ENV=dev
APP_SECRET=your_secret_here

# JWT configuration
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=your_passphrase_here
JWT_TOKEN_TTL=3600
```

### 2. Démarrer les services

```bash
# Construire et démarrer tous les services
docker-compose up -d --build

# Ou pour voir les logs en temps réel
docker-compose up --build
```

### 3. Accéder aux services

Une fois les services démarrés, vous pouvez accéder à :

- **phpMyAdmin** : http://localhost:8080
  - Utilisateur : `root`
  - Mot de passe : `root`

- **API Symfony** : http://localhost:8000

- **Application Angular** : http://localhost:4200

### 4. Configuration de la base de données

#### Via phpMyAdmin :
1. Ouvrez http://localhost:8080
2. Connectez-vous avec `root` / `root`
3. La base de données `concert_booking` sera automatiquement créée

#### Via Symfony CLI :
```bash
# Accéder au conteneur Symfony
docker-compose exec symfony bash

# Créer la base de données
php bin/console doctrine:database:create

# Exécuter les migrations
php bin/console doctrine:migrations:migrate

# Charger les fixtures (données de test)
php bin/console doctrine:fixtures:load
```

### 5. Commandes utiles

```bash
# Voir les logs
docker-compose logs -f

# Arrêter les services
docker-compose down

# Redémarrer un service spécifique
docker-compose restart symfony

# Supprimer les volumes (attention : supprime les données)
docker-compose down -v
```

## Utilisation de phpMyAdmin

### Connexion
1. Ouvrez votre navigateur et allez sur http://localhost:8080
2. Utilisez les identifiants :
   - **Serveur** : `database` (ou laissez vide)
   - **Utilisateur** : `root`
   - **Mot de passe** : `root`

### Fonctionnalités disponibles
- **Gestion des bases de données** : Créer, supprimer, modifier
- **Gestion des tables** : Structure, données, index
- **Requêtes SQL** : Exécuter des requêtes personnalisées
- **Import/Export** : Sauvegarder et restaurer des données
- **Utilisateurs** : Gérer les permissions

### Exemples d'utilisation

#### Voir la structure de la base de données
1. Cliquez sur `concert_booking` dans le menu de gauche
2. Vous verrez toutes les tables de votre application

#### Exécuter une requête SQL
1. Cliquez sur l'onglet "SQL"
2. Tapez votre requête, par exemple :
   ```sql
   SELECT * FROM user;
   ```

#### Exporter des données
1. Sélectionnez une table
2. Cliquez sur "Exporter"
3. Choisissez le format (SQL, CSV, etc.)

## Dépannage

### Problèmes courants

#### phpMyAdmin ne se connecte pas
- Vérifiez que le service `database` est démarré
- Attendez que MySQL soit complètement initialisé (peut prendre 1-2 minutes)

#### Erreur de connexion à la base de données
- Vérifiez que le fichier `.env` est correctement configuré
- Redémarrez les services : `docker-compose restart`

#### Ports déjà utilisés
- Changez les ports dans `docker-compose.yml` si nécessaire
- Vérifiez qu'aucune autre application n'utilise les ports 3306, 8080, 8000, 4200

### Logs utiles
```bash
# Logs de la base de données
docker-compose logs database

# Logs de phpMyAdmin
docker-compose logs phpmyadmin

# Logs de Symfony
docker-compose logs symfony
``` 