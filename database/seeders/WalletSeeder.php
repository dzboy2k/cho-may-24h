<?php

namespace Database\Seeders;

use App\Models\DepreciationSupportTransaction;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (!$user->wallet) {
                Wallet::insertGetId([
                    'user_id' => $user->id,
                    'payment_coin' => in_array($user->role_id, config('constants.SPECIAL_ROLES')) ? 1000000000 : 0,
                    'sale_limit' => 0,
                    'depreciation_support_limit' => 0,
                    'get_depreciation_support' => 0
                ]);
            }
        }
    }
}