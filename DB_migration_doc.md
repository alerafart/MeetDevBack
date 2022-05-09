## Flipbox setup

use Flipbox\LumenGenerator\LumenGeneratorServiceProvider;

`composer require flipbox/lumen-generator`

Inside your bootstrap/app.php file, in the 'Register Service Providers' section, add:
`$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);`

Generate the key that will connect our app to the DB
`php artisan key:generate`
The genrated key will automatically be copied in the .env file.

### Create new migration
This command will create a new migration file into the database folder and a model file for the new table
`php artisan make:model myEntity -fmc`
In the migration file, add the properties you want to appear in the table and then send it for creation to the DB with this command:
`php artisan migrate`


To create a new migration for an existant table:
`php artisan make:migration add_row_into_myEntity_table --table=myEntity`


### Create dummies in your entities using Faker
In the model file of a table, start by adding the following lines:
`use Illuminate\Database\Eloquent\Factories\HasFactory;`
`use HasFactory;`

Then, in the corresponding factory file, fill the desired properties with faker keywords and when it's done, launch the tinker console and request dummies creation:
`php artisan tinker`
`App\Models\myEntity::factory()->count(3)->create()`

