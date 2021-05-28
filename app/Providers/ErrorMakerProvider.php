<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ErrorMakerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton("App\ErrorMaker\ErrorMaker", "App\ErrorMaker\ErrorMaker");
    }
}
