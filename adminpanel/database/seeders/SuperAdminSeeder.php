<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $user = User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'name'          => 'Super Admin',
                'email'         => 'superadmin@chennaiangadi.com',
                'phone'         => '9999999999',
                'password'      => Hash::make('SuperAdmin@123'),
                'role_type'     => 'superadmin',
                'role_id'       => null,
                'profile_image' => null,
                'status'        => 1,
            ]
        );

        $this->command->info('✅ Super Admin created successfully!');
        $this->command->info('   Username: superadmin');
        $this->command->info('   Password: SuperAdmin@123');
    }
}
