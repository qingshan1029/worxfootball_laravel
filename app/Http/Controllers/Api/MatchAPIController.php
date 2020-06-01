<?php
namespace App\Http\Controllers\Api;
use App\Booking;
use App\Http\Controllers\Controller;
use App\Match;
use App\Player;
use Validator;
use Illuminate\Http\Request;


class MatchAPIController extends Controller
{
    public $successStatus = 200;

    public function getMatches(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => [
                'required',
            ],
            'latitude' => [
                'required',
            ],
            'longitude' => [
                'required',
            ],
            'radius' => [
                'required',
            ],
        ]);

        if ($validator->fails($request)) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

//      $request = ['start_time'=>'2020-05-20 10:00:00', "latitude" => '53.2535714', "longitude" => '-1.4257437'];
        $today = date("Y-m-d", strtotime($request['start_time']));
        $matches = $this->findNearestMatches($today, $request['latitude'], $request['longitude'], $request['radius']);



        return response()->json(['data' => $matches], $this-> successStatus);
    }



    private function findNearestMatches($today, $latitude, $longitude, $radius = 1500)
    {
        /*
         * using eloquent approach, make sure to replace the "Restaurant" with your actual model name
         * replace 6371000 with 6371 for kilometer and 3956 for miles
         */
        $tomorrow = date('Y-m-d',strtotime($today . "+1 days"));
        $matches = Match::selectRaw("matches.id as match_id, matches.*,
                         ( 6371000 * acos( cos( radians(?) ) *
                           cos( radians( latitude ) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( latitude ) ) )
                         ) AS distance", [$latitude, $longitude, $latitude])
            ->where([['active', '=', 1],
                ['start_time', '>=', $today],
                ['start_time', '<', $tomorrow],
            ])
            ->having("distance", "<", $radius)
            ->orderBy("distance",'asc') // oder by nearest neighbour
            ->offset(0)
            ->limit(20)
            ->get();

        $data = [];
        foreach($matches as $match) {
            $players = Booking::selectRaw("*")
                        ->leftJoin('players', 'bookings.player_id', '=', 'players.id')
                        ->where('match_id', '=', $match['id'])->get();

            $data[] = $this->makeMainMatch($match, $players);
        }

        return $data;
    }

    public function makeMainMatch($match, $players) {

        return [
            'id' => $match->id,
            'host_photo' => $match->host_photo,
            'host_name' => $match->host_name,
            'title' => $match->title,
            'start_time' => $match->start_time,
            'address' => $match->address,
            'latitude' => $match->latitude,
            'longitude' => $match->longitude,
            'rules' => $match->rules,
            'max_players' => $match->max_players,
            'reservations' => $match->reservations,
            'credits' => $match->credits,
            'players' => $players,
        ];
    }
}
