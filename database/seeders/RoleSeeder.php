<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadminRole = [
            'name' => Role::SUPERADMIN_ROLE_NAME
        ];

        $adminRole = [
            'name' => Role::ADMIN_ROLE_NAME
        ];

        Role::create($superadminRole);
        Role::create($adminRole);
    }
}
