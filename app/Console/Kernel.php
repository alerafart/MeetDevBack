<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }

    protected $routeMiddleware = [

                'jwt.verify' => \App\Http\Middleware\JwtMiddleware::class,
                'jwt.auth' => 'Tymon\JWTAuth\Middleware\GetUserFromToken',
                'jwt.refresh' => 'Tymon\JWTAuth\Middleware\RefreshToken',
            ];
}
