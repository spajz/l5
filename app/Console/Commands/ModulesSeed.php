<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        $this->info('Seeding database from modules.');

        $modules = modules('all');
        $moduleName = $this->input->getArgument('module');

        if ($modules) {

            if($moduleName && isset($modules[strtolower($moduleName)])){
                app('module')->seed(strtolower($moduleName));
            } else {
                foreach($modules as $key => $module){
                    app('module')->seed($key);
                }
            }
        }

//        // Get all modules or 1 specific
//        if ($moduleName = $this->input->getArgument('module')) $modules = array(app('modules')->module($moduleName));
//        else                                                   $modules = app('modules')->modules();
//
//        foreach ($modules as $module)
//        {
//            if ($module)
//            {
//                if ($module->def('seeder'))
//                {
//                    $module->seed();
//                    $this->info("Seeded '" . $module->name() . "' module.");
//                }
//                else
//                {
//                    $this->line("Module <info>'" . $module->name() . "'</info> has no seeds.");
//                }
//            }
//            else
//            {
//                $this->error("Module '" . $moduleName . "' does not exist.");
//            }
//        }
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
