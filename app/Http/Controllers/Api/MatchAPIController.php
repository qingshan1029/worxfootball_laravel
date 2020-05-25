<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Match;
use Validator;
use Illuminate\Http\Request;

class MatchAPIController extends Controller
{
    public $successStatus = 200;

    public function getMatches(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'token' => [
//                'required',
//            ],
//            'email' => [
//                'required',
//            ],
//            'host_name'    => [
//                'required',
//            ],
            'start_time' => [
                'required',
            ],
            'latitude' => [
                'required',
            ],
            'longitude' => [
                'required',
            ],
        ]);

        if ($validator->fails($request)) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

//      $request = ['start_time'=>'2020-05-20 10:00:00', "latitude" => '53.2535714', "longitude" => '-1.4257437'];
        $today = date("Y-m-d", strtotime($request['start_time']));
        $matches = $this->findNearestRestaurants($today, $request['latitude'], $request['longitude'], 1500);

        return response()->json(['data' => $matches], $this-> successStatus);
    }

    private function findNearestRestaurants($today, $latitude, $longitude, $radius = 1500)
    {
        /*
         * using eloquent approach, make sure to replace the "Restaurant" with your actual model name
         * replace 6371000 with 6371 for kilometer and 3956 for miles
         */

        /**
         * retrieve only matches today
         */
        $tomorrow = date('Y-m-d', strtotime($today . "+1 days"));
        $matches = Match::selectRaw("host_photo, host_name, title, start_time, address,
                        latitude, longitude, rules, players,
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
            ->orderBy("distance", 'asc')
            ->offset(0)
            ->limit(20)
            ->get();
        return $matches;
    }
}
