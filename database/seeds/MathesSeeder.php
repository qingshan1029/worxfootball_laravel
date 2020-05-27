<?php

use Illuminate\Database\Seeder;

class MathesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('matches')->delete();

        $matches = [
            [
                'host_photo' => 'host_photo_empty.png',
                'host_name' => 'Football King',
                'title' => 'Football',
                'start_time' => '2020-05-20 10:00:00',
                "address" => "Proact Stadium - home to Chesterfield FC, Sheffield Road, Chesterfield",
                "latitude" => 53.2535714,
                "longitude" => -1.4257437,
                'rules' => 18,
                'reservations' => 0,
                'active' => 1,
                'credits' => 1,
            ],
            [
                'host_photo' => 'host_photo_empty.png',
                'host_name' => 'Football King',
                'title' => 'Football',
                'start_time' => '2020-05-26 21:21:26',
                "address" => "Manchester City Football Match Day Ticket Sales, Ashton New Road, Manchester",
                "latitude" => 53.4841079,
                "longitude" => -2.200671,
                'rules' => 12,
                'reservations' => 2,
                'active' => 1,
                'credits' => 1,
            ],
            [
                'host_photo' => 'host_photo_empty.png',
                'host_name' => 'Football King',
                'title' => 'Football',
                'start_time' => '2020-05-20 16:00:00',
                "address" => "Peninsula Stadium, Moor Lane, Salford",
                "latitude" => 53.51363499,
                "longitude" => -2.2767797,
                'rules' => 22,
                'reservations' => 0,
                'active' => 1,
                'credits' => 1,
            ],
            [
                'host_photo' => 'host_photo_empty.png',
                'host_name' => 'Football King',
                'title' => 'Football',
                'start_time' => '2020-05-24 10:30:00',
                "address" => "Bury Football Stadium, Gigg Lane, Bury",
                "latitude" => 53.5805097,
                "longitude" => -2.2948209,
                'rules' => 14,
                'reservations' => 0,
                'active' => 1,
                'credits' => 1,
            ],
            [
                'host_photo' => 'host_photo_empty.png',
                'host_name' => 'Football King',
                'title' => 'Football',
                'start_time' => '2020-05-20 16:30:00',
                "address" => "University of Bolton Stadium, Burnden Way, Horwich, Bolton",
                "latitude" => 53.5813723,
                "longitude" => -2.5369749,
                'rules' => 12,
                'reservations' => 0,
                'active' => 1,
                'credits' => 1,
            ],
            [
                'host_photo' => 'host_photo_empty.png',
                'host_name' => 'Football King',
                'title' => 'Football',
                'start_time' => '2020-05-19 09:30:00',
                "address" => "DW Stadium, Loire Drive, Robin Park Road, Wigan",
                "latitude" => 53.5476804,
                "longitude" => -2.6541071,
                'rules' => 16,
                'reservations' => 0,
                'active' => 1,
                'credits' => 1,
            ],
            [
                'host_photo' => 'host_photo_empty.png',
                'host_name' => 'Football King',
                'title' => 'Football',
                'start_time' => '2020-05-24 09:30:00',
                "address" => "Blackburn Rovers, Blackburn",
                "latitude" => 53.7286169,
                "longitude" => -2.4891799,
                'rules' => 12,
                'reservations' => 0,
                'active' => 1,
                'credits' => 1,
            ],
            [
                'host_photo' => 'host_photo_empty.png',
                'host_name' => 'Football King',
                'title' => 'Football',
                'start_time' => '2020-05-27 10:00:00',
                "address" => "Crown Ground, Livingstone Road, Accrington",
                "latitude" => 53.76523359999999,
                "longitude" => -2.3708631,
                'rules' => 10,
                'reservations' => 0,
                'active' => 1,
                'credits' => 1,
            ],
            [
                'host_photo' => 'host_photo_empty.png',
                'host_name' => 'Football King',
                'title' => 'Football',
                'start_time' => '2020-05-24 17:00:00',
                "address" => "Burnley Football Club, Harry Potts Way, Burnley",
                "latitude" => 53.788987,
                "longitude" => -2.230187,
                'rules' => 12,
                'reservations' => 0,
                'active' => 1,
                'credits' => 1,
            ],
            [
                'host_photo' => 'host_photo_empty.png',
                'host_name' => 'Football King',
                'title' => 'Football',
                'start_time' => '2020-05-23 15:00:00',
                "address" => "Elland Road, Elland Road, Beeston, Leeds",
                "latitude" => 53.7778162,
                "longitude" => -1.5721446,
                'rules' => 14,
                'reservations' => 0,
                'active' => 1,
                'credits' => 1,
            ],
        ];

        DB::table('matches')->insert($matches);
    }
}
