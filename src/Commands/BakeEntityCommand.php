<?php

namespace Flamerecca\Bakerflow\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class BakeEntityCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bakerflow:bake:entity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bakerflow bake entity';

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}