<?php

namespace Database\Seeders;

use App\Constant\Constants;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AspireUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name'          => 'Admin',
            'email'         => 'admin@yopmail.com',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('Admin@123'),
            'role_id'       => Constants::TYPE_ADMIN,
            'state_id'   => 1,
            'created_at' => Carbon::now(),
        ]);
        $adminRole = Role::where('name', 'Admin')->where('type_id', Constants::TYPE_ADMIN)->first();
        if (!empty($adminRole)) {
            $roles = new RoleUser();
            $roles->role_id = $adminRole->id;
            $roles->user_id = $admin->id;
            $roles->save();
        }
        $userRole = Role::where('name', 'User')->where('type_id', Constants::TYPE_USER)->first();

        $user1 = User::create([
            'name'          => 'Testing User',
            'email'         => 'testing@yopmail.com',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('User1@123'),
            'role_id'       => Constants::TYPE_USER,
            'state_id'   => 1,
            'created_at' => Carbon::now(),
        ]);
        if (!empty($userRole)) {
            $roles = new RoleUser();
            $roles->role_id = $userRole->id;
            $roles->user_id = $user1->id;
            $roles->save();
        }
        $user2 = User::create([
            'name'          => 'Testing User 2',
            'email'         => 'testing2@yopmail.com',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('User2@123'),
            'role_id'       => Constants::TYPE_USER,
            'state_id'   => 1,
            'created_at' => Carbon::now(),
        ]);
        if (!empty($userRole)) {
            $roles = new RoleUser();
            $roles->role_id = $userRole->id;
            $roles->user_id = $user2->id;
            $roles->save();
        }
        $user3 = User::create([
            'name'          => 'Testing User 3',
            'email'         => 'testing3@yopmail.com',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('User3@123'),
            'role_id'       => Constants::TYPE_USER,
            'state_id'   => 1,
            'created_at' => Carbon::now(),
        ]);
        if (!empty($userRole)) {
            $roles = new RoleUser();
            $roles->role_id = $userRole->id;
            $roles->user_id = $user3->id;
            $roles->save();
        }
    }
}
