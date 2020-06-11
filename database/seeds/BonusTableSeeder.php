<?php

use Illuminate\Database\Seeder;

class BonusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bonus = [
            [
                'id'            => 1,
                'active'        => false,
                'from_date'     => now(),
                'to_date'       => now(),             // 1 days = 60s * 60min *24 h
                'amount'        => 20,                     // increase bonus(virtual money)
                'created_at'       => now(),          //
            ],
        ];

        DB::table('bonuses')->insert($bonus);
    }
}
