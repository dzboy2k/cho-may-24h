<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:storage {--f=?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command working with storage folders.';

    /**
     * Execute the console command.
     *
     * @return void
     */

    public function handle()
    {
//        NOTE : f option to define that folder will delete , exp : --f
        $folder = $this->option('f');
        $public_disk = Storage::disk('public');
        if ($folder !== "?") {
            if ($folder === null) {
                $this->error("Option--f need a folder\'s name.\nExp : php artisan fresh:storage --f=brands");
                return;
            }
            if (!$public_disk->exists($folder)) {
                $this->warn($folder . "folder does not exists!");
                return;
            }
            if ($this->confirm('Do u really want delete ' . $folder . 'folder?')) {
                $public_disk->deleteDirectory($folder);
                $this->line('Deleted ' . $folder . "!");
            }
            return;
        }

        $allDisk = Storage::disk('public')->allDirectories();
        $except_disk = explode(',', env('EXCEPT_STORAGE_FOLDER'));
        foreach ($allDisk as $disk) {
            if (in_array($disk, $except_disk)) {
                continue;
            }
            $public_disk->deleteDirectory($disk);
        }
        $this->info('Fresh storage successfully!');
    }
}
