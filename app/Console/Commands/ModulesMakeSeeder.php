<?php namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Foundation\Composer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModulesMakeSeeder extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'modules:make:seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module database seed class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Seed';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $name = $this->parseName($this->getNameInput());

        if ($this->files->exists($path = $this->getPath($name)))
        {
            return $this->error($this->type.' already exists!');
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type.' created successfully.');

        app('composer')->dumpAutoloads();
        $this->info('Composer dump-autoload executed.');

    }

    /**
     * Parse the name and format according to the root namespace.
     *
     * @param  string $name
     * @return string
     */
    protected function parseName($name)
    {
        return ucwords(camel_case($name)) . 'TableSeeder';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../stubs/modules/seeder.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = $this->argument('name');
        $class = $this->option('class');
        if ($class) {
            $className = $class . '.php';
        } else {
            $className = $name . 'TableSeeder.php';
        }

        return './app/Modules/' . $name . '/Database/Seeds/' . $className;
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string $stub
     * @param  string $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            '{{namespace}}', $this->getNamespace($name), $stub
        );

        $stub = str_replace(
            '{{rootNamespace}}', $this->getAppNamespace(), $stub
        );

        $stub = str_replace(
            '{{name}}', strtolower(str_plural($this->argument('name'))), $stub
        );

        $stub = str_replace(
            '{{module}}', $this->argument('name'), $stub
        );

        return $this;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the module.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['class', null, InputOption::VALUE_OPTIONAL, 'The name of the class.'],
        ];
    }



}
