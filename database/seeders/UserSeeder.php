<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'User',
                'email' => 'afrizalmalnabima@gmail.com',
                'email_verified_at' => Carbon::now(),
                'phone_num' => '089111000123',
                'phone_num_verified_at' => Carbon::now(),
                'role_id' => 1,
                'status' => 1,
                'password' => Hash::make('afrizalmalnabima@gmail.com'),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => Carbon::now(),
                'phone_num' => '089111000111',
                'phone_num_verified_at' => Carbon::now(),
                'role_id' => 2,
                'status' => 1,
                'password' => Hash::make('admin@gmail.com'),
            ],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'email_verified_at' => Carbon::now(),
                'phone_num' => '089111000333',
                'phone_num_verified_at' => Carbon::now(),
                'role_id' => 3,
                'status' => 1,
                'password' => Hash::make('superadmin@gmail.com'),
            ],
        ];

        User::insert($user);
    }
}
