<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Chms as ChmsService;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*
        $this->app->singleton('chms', function($app) {
            return new ChmsService; // TODO: config
        });
        */

        $this->app->bind('Psr\Http\Message\RequestInterface','GuzzleHttp\Psr7\Request');
        $this->app->bind('Psr\Http\Message\ResponseInterface','GuzzleHttp\Psr7\Response');
        $this->app->bind('App\Services\ChmsService','App\Services\ArenaService');
    }
}
