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


## Composer packages for email sending feature
`composer require illuminate/mail`

### Guzzle HTTP library
`composer require guzzlehttp/guzzle`
*required*

#### Postmark Driver
`composer require wildbit/swiftmailer-postmark`
#### Amazon SES driver
`composer require aws/aws-sdk-php`

## Composer packages for email notification
`composer require illuminate/notifications`

## Composer packages PHP library for generating and working with universally unique identifiers (UUIDs)
`composer require ramsey/uuid`

## implementation of all of Laravel's authentication features
`composer require laravel/breeze --dev`
`composer require breeze`
