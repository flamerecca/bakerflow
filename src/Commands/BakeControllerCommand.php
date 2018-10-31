<?php

namespace Flamerecca\Bakerflow\Commands;

use File;
use Flamerecca\Bakerflow\Generators\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Flamerecca\Bakerflow\Exceptions\FileAlreadyExistsException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class BakeControllerCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bakerflow:bake:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bake Controller without service';
    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of model for which the controller is being generated.',
                null
            ],
        ];
    }

    /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            [
                'fillable',
                null,
                InputOption::VALUE_OPTIONAL,
                'The fillable attributes.',
                null
            ],
            [
                'rules',
                null,
                InputOption::VALUE_OPTIONAL,
                'The rules of validation attributes.',
                null
            ],
            [
                'validator',
                null,
                InputOption::VALUE_OPTIONAL,
                'Adds validator reference to the repository.',
                null
            ],
            [
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force the creation if file already exists.',
                null
            ]
        ];
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        $this->handle();
    }

    /**
     * Execute the command.
     *
     * @see fire()
     * @return void
     */
    public function handle()
    {
        // TODO WIP
    }
}
