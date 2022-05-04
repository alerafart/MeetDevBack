use Flipbox\LumenGenerator\LumenGeneratorServiceProvider;

terminal
composer require flipbox/lumen-generator

copier code dans fichier boostrap/app.php
Inside your bootstrap/app.php file, add:
$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);


//generation tables bdd
```php artisan key:generate
php artisan make:model users -fmc```

//apres cette commande modifier fichier generé dans database/migrations
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
App\Models\users::factory()->count(2)->create()
App\Models\developers::factory()->count(2)->create()
```

dans routes web.php
créer route

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
