<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[Signature('make:service {name}')]
#[Description('Create a new service class')]
class createService extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $path = app_path("Services/{$name}.php");

        if (File::exists($path)) {
            $this->error("Service already exists!");
            return;
        }

        // Ensure directory exists
        if (!File::isDirectory(app_path('Services'))) {
            File::makeDirectory(app_path('Services'), 0755, true);
        }

        $stub = $this->getStub($name);

        File::put($path, $stub);

        $this->info("Service created successfully: {$name}");
    }


    protected function getStub($name)
    {
        return "<?php

        namespace App\Services;

        class {$name}
        {
            public function __construct()
            {
                //
            }
        }";
    }

}
