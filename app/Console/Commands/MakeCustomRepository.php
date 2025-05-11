<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeCustomRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:abstract {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $files;


    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $this->createRepository($name);
        $this->createInterface($name);
        $this->updateServiceProvider($name);
        $this->info("Repository for {$name} created successfully");
    }

    protected function createRepository($name)
    {
        $repositoryDirectory = app_path("Repositories/{$name}");
        $repositoryFile = "{$repositoryDirectory}/{$name}Repository.php";

        if (!$this->files->isDirectory($repositoryDirectory)) {
            $this->files->makeDirectory($repositoryDirectory, 0755, true);
        }

        $stub = $this->getRepositoryStub();
        $stub = str_replace('{{name}}', $name, $stub);

        $this->files->put($repositoryFile, $stub);
    }

    protected function createInterface($name)
    {
        $repositoryDirectory = app_path("Repositories/{$name}");
        $interfaceFile = "{$repositoryDirectory}/{$name}RepositoryInterface.php";

        if (!$this->files->isDirectory($repositoryDirectory)) {
            $this->files->makeDirectory($repositoryDirectory, 0755, true);
        }

        $stub = $this->getInterfaceStub();
        $stub = str_replace('{{name}}', $name, $stub);

        $this->files->put($interfaceFile, $stub);
    }

    protected function updateServiceProvider($name)
    {
        $providerPath = app_path('Providers/RepositoryServiceProvider.php');
        $interface = "\\App\\Repositories\\{$name}\\{$name}RepositoryInterface";
        $repository = "\\App\\Repositories\\{$name}\\{$name}Repository";
    
        $bindStatement = "\$this->app->bind({$interface}::class, {$repository}::class);";
    
        if ($this->files->exists($providerPath)) {
            $providerContent = $this->files->get($providerPath);
    
            if (strpos($providerContent, $bindStatement) === false) {
                $pattern = '/(\$this->app->bind\(.*?\);)(?!.*\$this->app->bind)/s';
                $replacement = "$1\n        $bindStatement";
                $providerContent = preg_replace($pattern, $replacement, $providerContent);
    
                $this->files->put($providerPath, $providerContent);
                $this->info("Repository bindings for {$name} added to RepositoryServiceProvider.");
            } else {
                $this->info("Repository bindings for {$name} already exist in RepositoryServiceProvider.");
            }
        } else {
            $this->error("RepositoryServiceProvider.php not found.");
        }
    }
    
    

    protected function getRepositoryStub()
    {
        $modelName = '$model';
        return <<<EOT
        <?php

        namespace App\Repositories\{{name}};

        use App\Models\{{name}};
        use App\Repositories\CrudRepository;

        class {{name}}Repository extends CrudRepository implements {{name}}RepositoryInterface
        {
            public function __construct({{name}} $modelName)
            {
                parent::__construct($modelName);
            }
        }
        EOT;
    }

    protected function getInterfaceStub()
    {
        return <<<EOT
        <?php

        namespace App\Repositories\{{name}};
        
        use App\Repositories\CrudRepositoryInterface;
        
        interface {{name}}RepositoryInterface extends CrudRepositoryInterface
        {
        }
        EOT;
    }
}
