<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InitApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:app {--cs}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This comment help init all stuff to make this app ready to deploy';

    /**
     * Execute the console command.
     *
     * @return void
     */

    public function handle()
    {
        $this->comment("freshing DB");
        try {
            \Artisan::call('fresh:db');
            $this->info('Fresh database success');
        } catch (\Exception $e) {
            echo "Please turn on your DB and try php artisan fresh:db later\n";
        }
        \Artisan::call('stub:publish');
        $this->info('Publish stub success!');
        \Artisan::call('update:env');
        $this->info('Update env success!');
        \Artisan::call('clean:storage');
        $this->info('Clear storage success');
            Artisan::call('storage:link');
        Artisan::call('init:res');
        $this->info("Init app success");
    }
}
