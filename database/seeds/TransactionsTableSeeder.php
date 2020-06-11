<?php

use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = [
//            [
//                'id'            => 1,
//                'player_id'     => 1,
//                'match_id'      => 0,
//                'datetime'      => '2020-06-04 10:35:29',   // event time
//                'description'   => 'Stripe payment for booking on WORX'
//                'event_name'    => 'charge',                // charge
//                'credit'        => 100,                     // charged 100 pound
//                'amount'        => 100,                     // increase virtual money
//            ],
//            [
//                'id'            => 2,
//                'player_id'     => 1,
//                'match_id'      => 1,
//                'datetime'      => '2020-06-04 11:05:02',   // event time
//                'description'   => 'Booking payment  '
//                'event_name'    => 'reserved',              // reservation
//                'credit'        => 0,                       // none
//                'amount'        => -20,                     // decrease virtual money
//            ],
//            [
//                'id'            => 3,
//                'player_id'     => 1,
//                'match_id'      => 0,
//                'datetime'      => '2020-06-04 10:35:29',   // event tim
//                'description'   => 'Gained the joined bonus'
//                'event_name'    => 'bonus',                 // bonus
//                'credit'        => 0,                       // none
//                'amount'        => 10,                      // increase virtual money(birthday, or ...)
//            ],
//            [
//                'id'            => 4,
//                'player_id'     => 1,
//                'match_id'      => 0,
//                'datetime'      => '2020-06-04 10:35:29',   // event tim
//                'description'   => 'Gained the birthday bonus'
//                'event_name'    => 'bonus',                 // bonus
//                'credit'        => 0,                       // none
//                'amount'        => 10,                      // increase virtual money(birthday, or ...)
//            ],
        ];

        DB::table('transactions')->insert($transactions);
    }
}
