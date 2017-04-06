<?php

use Vanguard\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin',
            'display_name' => 'Admin',
            'description' => 'System administrator.',
            'removable' => false
        ]);

        Role::create([
            'name' => 'Entry User',
            'display_name' => 'Entry User',
            'description' => 'Default system user.',
            'removable' => false
        ]);

        Role::create([
            'name'=>'Vendor Lead',
            'display_name' => 'Vendor Lead',
            'description' => 'Default vendor lead.',
            'removable' => false
        ]);
    }
}
