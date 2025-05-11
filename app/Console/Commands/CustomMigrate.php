<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

class CustomMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:custom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrate:fresh with optional seeding and passport setup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {

            if (App::environment('production')) {
                $this->error('This command cannot be run in the production environment.');
                return 1;
            }

            // Run migrate:fresh
            $this->info('Running migrate:fresh...');
            Artisan::call('migrate:fresh');
            $this->info(Artisan::output());

            // Check if the --seed option is present
            //  if ($this->option('seed')) {
            $this->info('Running db:seed...');
            Artisan::call('db:seed');
            $this->info(Artisan::output());
            //  }

            // Check if the --passport option is present
            //  if ($this->option('passport')) {
            // Running passport:client with --personal flag
            $this->info('Running passport:client --personal...');
            Artisan::call('passport:client', [
                '--personal' => true,
                '--name' => 'CGLP',
            ]);
            $this->info(Artisan::output());
            //  }

            return 0;
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            return 1;
        }
    }
}
