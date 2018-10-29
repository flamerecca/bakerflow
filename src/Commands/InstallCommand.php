<?php

namespace Flamerecca\Bakerflow\Commands;

use Flamerecca\Bakerflow\BakerflowServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\ImageServiceProviderLaravel5;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{

    protected $seedersPath = __DIR__.'/../../ingredients/seeders/';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bakerflow:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Bakerflow package';

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }

        return 'composer';
    }

    public function fire(Filesystem $filesystem)
    {
        return $this->handle($filesystem);
    }

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle(Filesystem $filesystem)
    {
        $this->info('Publishing the Bakerflow assets, database, config files and traits');
        $this->publishAsset();


        $this->info('Migrating the database tables into your application');
        $this->call('migrate');

        $this->info('Dumping the autoloaded files and reloading all new files');
        $this->composerReload();

        $this->info('Adding the storage symlink to your public folder');
        $this->call('storage:link');

        $this->info('Bakerflow Successfully Installed!');
    }

    /**
     * Publishing the Bakerflow assets, database, and config files
     */
    private function publishAsset()
    {
        $tags = ['bakerflow_assets', 'seeds'];
        $this->call('vendor:publish', ['--provider' => BakerflowServiceProvider::class, '--tag' => $tags]);
        $this->call('vendor:publish', ['--provider' => ImageServiceProviderLaravel5::class]);
    }

    /**
     * Dumping the autoload files in composer and reloading all new files
     */
    private function composerReload()
    {
        $composer = $this->findComposer();

        $process = new Process($composer.' dump-autoload');
        $process->setTimeout(null); // Setting timeout to null to prevent installation from stopping at a certain point in time
        $process->setWorkingDirectory(base_path())->run();
    }
}
