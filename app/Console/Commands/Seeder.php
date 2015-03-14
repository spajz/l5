<?php namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class Seeder extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new database seed class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Seed';

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
        return __DIR__ . '/../stubs/seeder.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string $name
     * @return string
     */
    protected function getPath($name)
    {
        return './database/seeds/' . str_replace('\\', '/', $name) . '.php';
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
            '{{name}}', strtolower($this->argument('name')), $stub
        );

        return $this;
    }

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

        $this->call('command:name', ['argument' => 'foo', '--option' => 'bar']);
    }


}
