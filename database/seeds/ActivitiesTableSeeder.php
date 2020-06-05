<?php

use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $activities = [
            [
                'id'            => 1,
                'player_id'     => 1,
                'type'          => 1,   // feedback
                'content'       => "Awesome",
            ],
            [
                'id'            => 2,
                'player_id'     => 1,
                'type'          => 2,   // report
                'content'       => "This app is wonderful",
            ],
            [
                'id'            => 3,
                'player_id'     => 2,
                'type'          => 1,   // feedback
                'content'       => "Great app",
            ],
//            [
//                'id'            => 4,
//                'player_id'     => 1,
//                'type'          => 3,   // deleted reason.
//                'content'       => "Because I have to move to the other area.",
//            ],
        ];

        DB::table('activities')->insert($activities);
    }
}
