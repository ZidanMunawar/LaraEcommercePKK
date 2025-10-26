<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingMethodSeeder extends Seeder
{
    public function run()
    {
        DB::table('shipping_methods')->insert([
            [
                'name' => 'JNE Regular',
                'cost' => 20000,
                'estimated_days' => '3-5 hari',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'JNE YES',
                'cost' => 35000,
                'estimated_days' => '1-2 hari',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'SiCepat Regular',
                'cost' => 18000,
                'estimated_days' => '3-4 hari',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'SiCepat BEST',
                'cost' => 30000,
                'estimated_days' => '1-2 hari',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'J&T Express',
                'cost' => 15000,
                'estimated_days' => '3-5 hari',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
