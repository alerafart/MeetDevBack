# How to install and run the project

## Start with Lumen
Install Composer
`composer install`
`composer dump-autoload`

If needed, require Lumen packages:
`composer require laravel/lumen-framework`


## DB setup
Create DB with permissions and import SQL script in docs/db_import.txt

### Update `.env`
Duplicate `.env.example`, rename as `.env` and fill DB_DATABASE, DB_USERNAME, DB_PASSWORD with the data you set previously in Adminer.

### Serve the project on PHP development server
`php -S localhost:8080 -t public`


## Composer packages for CORS authorizations handling 
`composer require nordsoftware/lumen-cors`

## Composer packages for JWT token authentification
`composer require tymon/jwt-auth`
Run `php artisan jwt:secret`. It will update the .env file.
Then add this line in the .env file `JWT_BLACKLIST_GRACE_PERIOD=120`

## Composer packages for email sending feature
`composer require illuminate/mail`
`composer require illuminate/notifications`
Then modify in the .env file as follow  
`MAIL_USERNAME=meetdev.apollo22@gmail.com
MAIL_PASSWORD=meetdev22`

### Guzzle HTTP library
`composer require guzzlehttp/guzzle`
*required*




