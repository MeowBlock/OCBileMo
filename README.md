[![Codacy Badge](https://app.codacy.com/project/badge/Grade/43464b523b844262a5e486324203d18b)](https://app.codacy.com/gh/MeowBlock/OCBileMo/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

# BileMo

This project is an api for a phone hardware company
## Installation

### Pre-requisites

in order to install my project you first need

- A webserver
- PHP version 8.2+
- Mysql version 8.0+
- Composer

#### What webserver do i use ?
I use Symfony's default webserver via Symfony CLI version 5.5.8, you can download Symfony's CLI [here](https://symfony.com/download)

#### How to install Composer
You may download and install the latest version of Composer [here](https://getcomposer.org/download/)

### Installation process

#### Download the files
download the files directly from github or clone the repository using 
```git clone https://github.com/MeowBlock/OCBileMo.git```

#### Install the Composer dependencies
Install the required librairies using Composer with the command ```composer install```

#### Set up the environment
you need to create a file named .env.local to set up the local environment variables.
the file must contain the same variables as the .env file - including DATABASE_URL

#### Import the database
Once you set up the DATABASE_URL variable to fit your local database you may import the database schema.
##### Import the schema
In order to import the database schema you have to use Doctrine.
Use the command ```php bin/console doctrine:migrations:migrate``` to import the latest migration.

##### Fixtures
You can load testing data by running the fixture script inside the project with the command ```php bin/console hautelook:fixtures:load```

### Authentication
In order to allow authentication, your server needs a valid JWT keypair, for that you need to run the command 
```php bin/console lexik:jwt:generate-keypair```
Or follow the JWT authentication tutorial [here](https://symfony.com/bundles/LexikJWTAuthenticationBundle/current/index.html)

## Documentation
You're all set ! now you can follow the Swagger / OpenApi UI in ```BASE_URL/docs```

