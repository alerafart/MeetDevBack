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


### Composer packages for CORS authorizations handling 
`composer require nordsoftware/lumen-cors`

## Composer packages for email sending feature
### Guzzle HTTP library
`composer require guzzlehttp/guzzle`

## Postmark Driver
`composer require wildbit/swiftmailer-postmark`
## Amazon SES driver
`composer require aws/aws-sdk-php`
