<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mockery\Exception;

class FreshDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fresh:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fresh migration and seed db';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            \Artisan::call('migrate:fresh');
            \Artisan::call('db:seed --class=VoyagerDatabaseSeeder');
            $this->info("Fresh database success!");
        }catch (Exception $exception){
            $this->error($exception->getMessage());
        }
    }
}
