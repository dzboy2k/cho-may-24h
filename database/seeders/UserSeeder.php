<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
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
        $admin = User::create([
            'name' => 'Chợ máy 24h Admin',
            'phone' => '0123456789',
            'email' => 'chomay24h@gmail.com',
            'role_id' => 1,
            'avatar' => config('constants.DEFAULT_AVT_PATH'),
            'password' => Hash::make('Chomay24h@#$'),
            'referral_code'=>'987654321',
        ]);

        User::create([
            'name' => 'demind',
            'phone' => '1234567890',
            'email' => 'demind@gmail.com',
            'role_id' => 3,
            'avatar' => config('constants.DEFAULT_AVT_PATH'),
            'password' => Hash::make('demindadmin'),
            'referral_code'=>'123456789',
        ]);

    }
}