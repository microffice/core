<?php namespace Microffice\Core\Tests\Stubs;

use Illuminate\Support\ServiceProvider;

/**
 * StubsServiceProvider
 *
 */ 

class StubsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
    * Bootstrap the application.
    *
    * @return void
    */
    public function boot()
    {

    }
        
    /**
     * Register everything.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('resource', function($app)
        {
            return new ResourceStubClass();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['resource'];
    }
}