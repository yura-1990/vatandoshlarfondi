<?php

namespace App\Providers;

use App\Services\CountService;
use Illuminate\Support\ServiceProvider;

class CountServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('count', function (){
            return new CountService();
        });
    }
}
