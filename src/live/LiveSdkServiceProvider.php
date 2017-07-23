<?php
namespace Goodspb\LiveSdk;

use Illuminate\Support\ServiceProvider;

class LiveSdkServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        if (function_exists('config_path')) {
            $publishPath = config_path('live.php');
        } else {
            $publishPath = base_path('config/live.php');
        }
        $this->publishes([__DIR__ . '/../config/live.php' => $publishPath], 'config');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/live.php', 'live');

        $this->app->singleton('Goodspb\\LiveSdk\\Live', function () {
            $live = new Live();
            $live->setConfig(config('live'));
            return $live;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Goodspb\\LiveSdk\\Live'];
    }
}
