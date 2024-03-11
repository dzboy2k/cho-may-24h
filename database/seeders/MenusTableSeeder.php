<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        Menu::firstOrCreate([
            'name' => 'admin',
        ]);
        Menu::firstOrCreate([
            'name' => 'header',
        ]);
        Menu::firstOrCreate([
            'name' => 'footer',
        ]);
        Menu::firstOrCreate([
            'name' => 'categories',
        ]);
        Menu::firstOrCreate([
            'name' => 'user',
        ]);
        Menu::firstOrCreate([
            'name' => 'submenu',
        ]);
        Menu::firstOrCreate([
            'name' => 'footer_nav_mobile',
        ]);
    }
}
