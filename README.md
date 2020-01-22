# Welcome to Korbenne Ramass' !
![enter image description here](https://cdn.discordapp.com/attachments/648455633820975114/653527446762553344/Korbenne-ramass.png) **Korbenne Rammas'** is a Student project whose purpose is to get Geolocalisation Data from a json file and exploit it on a web application.
This is the API part used with Symfony.
## Contributors :

 - [Ahmed Bouknana](https://github.com/AhmedBouk)
 - [Guillaume Gauthier](https://github.com/gauthierguillaume)
 - [Nicolas Becuwe](https://github.com/NikoFLK)
 - [Turpin Paul](https://github.com/Druxys)

## Requirements :
Prerequisites for the proper functioning of the application
 - [PHP 7.2](https://lmgtfy.com/?q=How%20to%20get%20php%207.2&iie=1)
 - [Composer](https://getcomposer.org/)
 - [Postgres SQL](https://www.postgresql.org/download/)
 - [Symfony 5.0](https://symfony.com/)

## Installation
Get the project :

    git clone git@github.com:AhmedBouk/Benne.git
    
Install bundles with composer :

    composer install
    
Generate the SSH keys :

    mkdir -p config/jwt 
    openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 
    openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
    
Create an .env.local, add your database URL & your SSH keys configuration. It look like this : 

    DATABASE_URL=postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=11&charset=utf8 
    JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem 
    JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem 
    JWT_PASSPHRASE=*yourPassphrase*

Create your Postgres database with the following commands:

    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
    
Launch Symfony with the following command :

    php -S localhost:8000 -t public

## Complementary Informations :
Dependencies/Bundles used :

 - [Doctrine](https://symfony.com/doc/5.0/doctrine.html)
 - [ramsey/uuid](https://github.com/ramsey/uuid)
 - [zircote/swagger-php](https://github.com/zircote/swagger-php)
 - [lexik/LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle)
 - [jsor/doctrine-postgis](https://github.com/jsor/doctrine-postgis)

