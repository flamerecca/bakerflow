<?php

namespace Flamerecca\Bakerflow\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Prettus\Repository\Generators\BindingsGenerator;
use Flamerecca\Bakerflow\Exceptions\FileAlreadyExistsException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class BakeEntityCommand extends Command
{
    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'bakerflow:bake:entity';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Bake a new entity';

    /**
     * The placeholder for repository bindings
     *
     * @var string
     */
    public $bindPlaceholder = '//:end-bindings:';

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
        try {

            $this->confirmPresenter();
            $this->confirmValidator();

            //create repository and repositoryEloquent by l5-command
            $this->call('make:repository', $this->arguments());

            $this->bakeBinding();

            $this->info('binding created successfully.');
        } catch (FileAlreadyExistsException $e) {
            $this->error('binding already exists!');
        }
    }

    /**
     *
     */
    private function confirmPresenter()
    {
        if ($this->confirm('Would you like to create a Presenter? [y|N]')) {
            $this->call('make:presenter', [
                'name'    => $this->argument('name'),
                '--force' => $this->option('force'),
            ]);
        }
    }

    /**
     *
     */
    private function confirmValidator(){
        $validator = $this->option('validator');
        if (is_null($validator) && $this->confirm('Would you like to create a Validator? [y|N]')) {
            $validator = 'yes';
        }

        if ($validator === 'yes') {
            $this->call('make:validator', [
                'name'    => $this->argument('name'),
                '--force' => $this->option('force'),
            ]);
        }
    }

    /**
     *
     */
    private function bakeBinding()
    {
        $provider = \File::get($this->getPath());
        $repositoryInterface = $this->getRepository() . "::class";
        $repositoryEloquent = $this->getEloquentRepository() . "::class";

        // TODO use stud to create binding part
        \File::put(
            $this->getPath(),
            str_replace(
                $this->bindPlaceholder,
                "\$this->app->bind("
                . PHP_EOL
                . "            {$repositoryInterface},"
                . PHP_EOL
                . "            $repositoryEloquent"
                . PHP_EOL
                . '        );'
                . PHP_EOL
                . '        '
                . $this->bindPlaceholder,
                $provider
            )
        );
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    private function getPath()
    {
        return app()->path() . '/Providers/RepositoryServiceProvider.php';
    }

    /**
     * Gets repository full class name
     *
     * @return string
     */
    private function getRepository()
    {
        $repository = '\\App\\Repositories\\' . $this->argument('name');

        return str_replace([
                "\\",
                '/'
            ], '\\', $repository) . 'Repository';
    }

    /**
     * Gets eloquent repository full class name
     *
     * @return string
     */
    private function getEloquentRepository()
    {
        $repository = '\\App\\Repositories\\' . $this->argument('name');

        return str_replace([
                "\\",
                '/'
            ], '\\', $repository) . 'RepositoryEloquent';
    }

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
}
