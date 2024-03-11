<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mockery\Exception;
use Symfony\Component\Console\Output\NullOutput;

class FakeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create fake data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Artisan::call('fresh:db');
        $this->info('Fresh database success');
        try {
            $seeders = [
                'ImageSeeder',
                'BrandSeeder',
                'ProviderSeeder',
                'PostsTableSeeder',
            ];

            foreach ($seeders as $seeder) {
                \Artisan::call('db:seed', ['--class' => $seeder], new NullOutput());
            }
            $this->info('The fake data was run successfully!');
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
