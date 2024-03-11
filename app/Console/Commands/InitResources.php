<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InitResources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:res';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init site default resources like , image , icon , ..etc';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $folder_resource = 'images';
            $public_storage_path = "app\public\\" . $folder_resource;
            $resources = [
                [public_path('images\user-default-avt.svg'), storage_path($public_storage_path . "\user-default-avt.svg")],
                [public_path(config('constants.DEFAULT_LOGO')), storage_path($public_storage_path . "\logo.png")],
                [public_path(config('constants.DEFAULT_FAVICON')), storage_path($public_storage_path . "\logo.svg")]
            ];
            foreach ($resources as $resource) {
                if (File::exists($resource[0])) {
                    if (!File::exists($resource[1])) {
                        Storage::disk('public')->makeDirectory($folder_resource);
                    }
                    File::copy($resource[0], $resource[1]);
                }
            }
        } catch (\Exception $exception) {
            $this->info('init resource failed with error : ' . $exception->getMessage());
        }
    }
}
