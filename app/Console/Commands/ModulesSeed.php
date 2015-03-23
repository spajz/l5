<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Foundation\Application;

class ModulesSeed extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'modules:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database from modules.';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        $this->info('Seeding database from modules.');

        $modules = modules('all');

        $moduleName = $this->input->getArgument('module');

        if ($modules && isset($modules[strtolower($moduleName)])) {
            if ($moduleName) {
                app('module')->seed(strtolower($moduleName));
                $this->info("Seeded '" . $moduleName . "' module.");
            } else {
                foreach ($modules as $key => $module) {
                    app('module')->seed($key);
                    $this->info("Seeded '" . $key . "' module.");
                }
            }
        } else {
            $this->error("Module does not exist.");
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::OPTIONAL, 'The name of module being seeded.'],
        ];
    }

}
