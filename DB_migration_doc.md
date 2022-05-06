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
`php artisan make:model users -fmc`
In the migration file, add the properties you want to appear in the table and then send it for creation to the DB with this command:
`php artisan migrate`


// pour rajouter colonne dans table existante
//ensuite relancer php artisan migration apres avois rajouté dans le nouveau fichier la ligne a rajouter dans la function de la classe
```
php artisan make:migration add_phone_to_users_table --table=users
php artisan migrate
```

```
php artisan tinker
// App\Models\User::factory()->count(2)->create()
// App\Models\Users::factory()->count(2)->create()
App\Models\users::factory()->count(4)->create()
App\Models\developers::factory()->count(2)->create()
App\Models\recruiters::factory()->count(2)->create()
```

dans routes web.php
créer route
------------------------------------------

```
$router->group(['prefix' => 'api'], function() use ($router){
    // $router->get(uri:'/posts', action:'PostController@index'); tuto php8
    $router->get('/posts', 'PostController@index');
});
```

dans PostController creer methode index
```
public function index(){
        return Post::all();
    }
```
//php artisan make:model languages -fmc
php artisan make:model messages -fmc
php artisan make:model recruiters -fmc```
php artisan make:model developers -fmc

App\Models\languages::factory()->count(2)->create()
