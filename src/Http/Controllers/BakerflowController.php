<?php

namespace Flamerecca\Bakerflow\Http\Controllers;

use Flamerecca\Bakerflow\Bakerflow;

class BakerflowController
{
    public function index()
    {
        return Bakerflow::view('bakerflow::index');
    }
}