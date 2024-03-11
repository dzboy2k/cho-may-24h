<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = Role::where('name', 'admin')->firstOrFail();
        $admin_permissions = Permission::whereNotIn('id',config('constants.ADMIN_PERMISSION_EXCEPT_IDS'));
        $dev_role = Role::where('name','dev')->firstOrFail();
        $dev_permission = Permission::all();

        $admin_role->permissions()->sync( $admin_permissions->pluck('id')->all() );
        $dev_role->permissions()->sync( $dev_permission->pluck('id')->all() );
    }
}
