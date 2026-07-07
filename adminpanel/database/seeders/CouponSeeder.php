<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get first available user or use NULL
        $user_id = \App\Models\User::first()?->id ?? 1;

        // Check if the user exists, if not, make created_by nullable in migration or use a default user
        Coupon::create([
            'code' => 'SAVE10',
            'description' => '10% discount on all products',
            'type' => 'percentage',
            'value' => 10,
            'min_amount' => 500,
            'max_discount' => 1000,
            'usage_limit' => 100,
            'used_count' => 0,
            'per_user_limit' => 5,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(30),
            'status' => true,
            'created_by' => $user_id,
        ]);

        Coupon::create([
            'code' => 'FLAT100',
            'description' => '₹100 flat discount',
            'type' => 'fixed',
            'value' => 100,
            'min_amount' => 1000,
            'usage_limit' => 50,
            'used_count' => 0,
            'per_user_limit' => 1,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(60),
            'status' => true,
            'created_by' => $user_id,
        ]);

        Coupon::create([
            'code' => 'WELCOME20',
            'description' => '20% discount for new users',
            'type' => 'percentage',
            'value' => 20,
            'min_amount' => 0,
            'max_discount' => 500,
            'usage_limit' => 200,
            'used_count' => 0,
            'per_user_limit' => 1,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(90),
            'status' => true,
            'created_by' => $user_id,
        ]);
    }
}
