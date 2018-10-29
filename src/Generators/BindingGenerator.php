<?php

namespace Flamerecca\Bakerflow\Generators;

use Illuminate\Support\Collection;

class BindingGenerator extends Generator
{
    /**
     * BindingGenerator constructor.
     * @param string $path
     * @param Collection $replaces
     */
    public function __construct(string $path, Collection $replaces)
    {
        parent::__construct($path, $replaces);
    }
}
