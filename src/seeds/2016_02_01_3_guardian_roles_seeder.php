<?php

namespace Database\Seeds;

use Cloudoki\Guardian\Models\Role;
use Illuminate\Database\Seeder;

class GuardianRolesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::create([
            'slug'          => 'role:view',
            'description'   => 'View roles'
        ]);

        Role::create([
            'slug'          => 'rolegroup:view',
            'description'   => 'View rolegroups'
        ]);

        Role::create([
            'slug'          => 'rolegroup:write',
            'description'   => 'Manage rolegroups'
        ]);

        Role::create([
            'slug'          => 'rolegroup:delete',
            'description'   => 'Delete rolegroups'
        ]);

    }
}
