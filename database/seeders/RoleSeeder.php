<?php

namespace Database\Seeders;

use App\Constant\Constants;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        Role::create([
            'id'            => 1,
            'name'          => 'Admin',
            'type_id'       => Constants::TYPE_ADMIN,
            'description'   => 'Use this account with extreme caution. When using this account it is possible to cause irreversible damage to the system.'
        ]);

        Role::create([
            'id'            => 2,
            'name'          => 'User',
            'type_id'       => Constants::TYPE_USER,
            'description'   => 'User Permissions'
        ]);
    }
}
