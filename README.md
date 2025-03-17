## About concert_booking

Concert_booking is an app where you can reserve ticket for concerts and festival.

## Contents

- [Project installation](#Project-installation)
   - [Requirements](#Requirements)
   - [Cloning the project](#Cloning-the-project)
   - [Symfony installation](#Symfony_installation)
- [Dependencies installation](#Dependencies-installation)
  - [API platform configuration](#API-platform-configuration)
  - [Database configuration](#Database-configuration)

## Project installation

### Requirements
- PHP 8.2
- Composer
- MySql
- Node.js 16.0.0
- npm

### Cloning the project

```bash
  git clone git@github.com:n-irina/concert_booking.git
  cd concert_booking
```

### Symfony installation

```bash
  composer install
```

## Dependencies installation

### API platform configuration

```bash
  composer require api
```

### Database configuration

First you need to install Doctrine and MakerBundle

```bash
  composer require symfony/orm-pack
  composer require --dev symfony/maker-bundle
```

To configure your database, go to the .env, uncomment the specific lines and change the information.

```.php
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8.0.37"
```

Now create your database with this command line

```bash
  php bin/console doctrine:database:create
```

Then you need to migrate

```bash
  php bin/console make:migration
```
```bash
  php bin/console doctrine:migrations:migrate
```
