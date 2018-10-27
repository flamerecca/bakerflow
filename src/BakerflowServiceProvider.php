<?php

namespace TCG\Voyager;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;


class BakerflowServiceProvider extends ServiceProvider
{
    public function register() {
  
    }
    
    public function boot(Router $router, Dispatcher $event)
    {
    
    }
  
}
