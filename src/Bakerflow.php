<?php

namespace Flamerecca\Bakerflow;

use Illuminate\Support\Facades\Facade;

class Bakerflow
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bakerflow';
    }

    public function routes()
    {
        require __DIR__.'/../routes/bakerflow.php';
    }
}
