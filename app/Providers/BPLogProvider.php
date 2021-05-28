<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BPLog;
use Config;
use DB;

class BPLogProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        BPLog::setLogLevel( Config::get('app.log_level') );

        DB::listen( function( $query ) {
            BPLog::debug( $query->sql );
            BPLog::debug( $query->bindings );
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\BPLog\BPLog', 'App\BPLog\BPLog');
    }
}
