<?php

use Illuminate\Database\Seeder;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $players = [
            [
                'id'             => 1,
                'email'          => 'test1@example.com',
                'password'       => bcrypt('123456'),
                'first_name'     => 'Jack',
                'last_name'      => 'Son',
                'birthday'       => '1995-01-01',
                'photo'          => 'photo_empty.png',
                'credits'        => 0,
                'status'         => 1,
                'created_at'     => now(),
            ],
            [
                'id'             => 2,
                'email'          => 'test2@example.com',
                'password'       => bcrypt('123456'),
                'first_name'     => 'Lucas',
                'last_name'      => 'Blade',
                'birthday'       => '1996-05-05',
                'photo'          => 'photo_empty.png',
                'credits'        => 0,
                'status'         => 1,
                'created_at'     => now(),
//                'password'       => '$2y$10$vUIzDlvfpu2yOATsPYcPaOTY/zgbgwViLIWSfZxSlmRBFV.g/fmOW',
            ],
        ];

        DB::table('players')->insert($players);
    }
}
