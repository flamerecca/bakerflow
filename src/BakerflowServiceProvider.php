<?php

namespace Flamerecca\Bakerflow;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;

class BakerflowServiceProvider extends ServiceProvider
{
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Bakerflow', Bakerflow::class);

        $this->app->singleton('bakerflow', function () {
            return new Bakerflow();
        });

        if ($this->app->runningInConsole()) {
            $this->registerConsoleCommands();
        }
    }
    
    public function boot(Router $router, Dispatcher $event)
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'bakerflow');
        if (config('app.env') == 'testing') {
            $this->loadMigrationsFrom(realpath(__DIR__.'/migrations'));
        }

        $this->loadMigrationsFrom(realpath(__DIR__.'/../migrations'));
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        $this->commands(Commands\InstallCommand::class);
        $this->commands(Commands\BakeEntityCommand::class);
        $this->commands(Commands\BakeControllerWithServiceCommand::class);
        $this->commands(Commands\BakeMongoEntityCommand::class);
    }
}
