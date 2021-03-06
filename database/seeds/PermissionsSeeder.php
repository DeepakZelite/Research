<?php

use Vanguard\Permission;
use Vanguard\Role;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', 'Admin')->first();

        $permissions[] = Permission::create([
            'name' => 'users.manage',
            'display_name' => 'Manage Users',
            'description' => 'Manage users and their sessions.',
            'removable' => false
        ]);

        $permissions[] = Permission::create([
            'name' => 'users.activity',
            'display_name' => 'View System Activity Log',
            'description' => 'View activity log for all system users.',
            'removable' => false
        ]);

        $permissions[] = Permission::create([
            'name' => 'roles.manage',
            'display_name' => 'Manage Roles',
            'description' => 'Manage system roles.',
            'removable' => false
        ]);

        $permissions[] = Permission::create([
            'name' => 'permissions.manage',
            'display_name' => 'Manage Permissions',
            'description' => 'Manage role permissions.',
            'removable' => false
        ]);

        $permissions[] = Permission::create([
            'name' => 'settings.general',
            'display_name' => 'Update General System Settings',
            'description' => '',
            'removable' => false
        ]);

        $permissions[] = Permission::create([
            'name' => 'settings.auth',
            'display_name' => 'Update Authentication Settings',
            'description' => 'Update authentication and registration system settings.',
            'removable' => false
        ]);

        $permissions[] = Permission::create([
            'name' => 'settings.notifications',
            'display_name' => 'Update Notifications Settings',
            'description' => '',
            'removable' => false
        ]);
        $permissions[] = Permission::create([
        		'name' => 'projects.manage',
        		'display_name' => 'Manage projects',
        		'description' => 'Manage projects',
        		'removable' => false
        ]);
        $permissions[] = Permission::create([
        		'name' => 'vendors.manage',
        		'display_name' => 'Manage Vendors',
        		'description' => 'Manage Vendors',
        		'removable' => false
        ]);
        $permissions[] = Permission::create([
        		'name' => 'batches.manage',
        		'display_name' => 'Manage batches',
        		'description' => 'Manage batches',
        		'removable' => false
        ]);
        $permissions[] = Permission::create([
        		'name' => 'subBatches.manage',
        		'display_name' => 'Manage subBatches',
        		'description' => 'Manage subBatches',
        		'removable' => false
        ]);
        
        $permissions[] = Permission::create([
        		'name' => 'companys.manage',
        		'display_name' => 'Manage companys',
        		'description' => 'Manage companys',
        		'removable' => false
        ]);
        

        $adminRole->attachPermissions($permissions);
    }
}
