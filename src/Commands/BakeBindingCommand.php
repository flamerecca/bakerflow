<?php

namespace Flamerecca\Bakerflow\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Prettus\Repository\Generators\BindingsGenerator;
use Flamerecca\Bakerflow\Exceptions\FileAlreadyExistsException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class BakeBindingCommand extends Command
{
    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'bakerflow:bake:binding';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Add repository bindings to service provider.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Bindings';

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
            //create repository and repositoryEloquent by l5-command
            $this->call('make:repository', $this->arguments());

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
            $this->info($this->type . ' created successfully.');
        } catch (FileAlreadyExistsException $e) {
            $this->error($this->type . ' already exists!');
        }
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
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force the creation if file already exists.',
                null
            ],
        ];
    }
}
