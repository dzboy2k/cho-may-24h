<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $role = Role::firstOrNew(['name' => 'admin']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.admin'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'user']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.user'),
            ])->save();
        }
        $role = Role::firstOrNew(['name' => 'dev']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'dev',
            ])->save();
        }
        $role = Role::firstOrNew(['name' => 'partner']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'partner',
            ])->save();
        }
    }
}
