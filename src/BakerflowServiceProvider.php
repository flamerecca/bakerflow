<?php

namespace Flamerecca\Bakerflow;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;

class BakerflowServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishableResources();
            $this->registerConsoleCommands();
        }
    }
    
    public function boot(Router $router, Dispatcher $event)
    {
        if (config('app.env') == 'testing') {
            $this->loadMigrationsFrom(realpath(__DIR__.'/migrations'));
        }

        $this->loadMigrationsFrom(realpath(__DIR__.'/../migrations'));
    }

    /**
     * Register the publishable files.
     */
    private function registerPublishableResources()
    {
        $ingredientsPath = dirname(__DIR__).'/ingredients';

        $ingredients = [
            'bakerflow_assets' => [
                "{$ingredientsPath}/assets/" => public_path(config('bakerflow.assets_path')),
            ],
            'seeds' => [
                "{$ingredientsPath}/seeders/" => database_path('seeds'),
            ],
            'config' => [
                "{$ingredientsPath}/config/bakerflow.php" => config_path('bakerflow.php'),
            ],
            'traits' => [
                "{$ingredientsPath}/traits/" => app()->path() . 'Traits/',
            ],

        ];

        foreach ($ingredients as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        $this->commands(Commands\InstallCommand::class);
    }
}
