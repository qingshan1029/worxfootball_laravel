<?php

use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookings = [
            [
                'id'             => 1,
                'match_id'       => 2,
                'player_id'        => 1,
            ],
            [
                'id'             => 2,
                'match_id'       => 2,
                'player_id'        => 2,
            ],
        ];

        DB::table('bookings')->insert($bookings);
    }
}
