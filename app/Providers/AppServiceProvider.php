<?php

namespace App\Providers;

use App\Services\UrlGenerator as UrlGenerator;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(App\Services\UrlGenerator::class, function () {
            $urlGeneratorWithSignedRoutes = new UrlGenerator($this->app);

            $urlGeneratorWithSignedRoutes->setKeyResolver(function () {
                return $this->app->make('config')->get('app.key');
            });

            return $urlGeneratorWithSignedRoutes;
        });
    }

}
