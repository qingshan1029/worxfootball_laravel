<?php
namespace App\Http\Controllers\Api;
use App\Activity;
use App\Booking;
use App\Http\Controllers\Controller;
use App\Player;
use App\Transaction;
use Validator;
use Illuminate\Http\Request;

class ActivityAPIController extends Controller
{
    public $successStatus = 200;

    public function getAll()
    {
        $activities = Activity::all();

        return response()->json(['data' => $activities], $this-> successStatus);
    }

    public function setFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => [
                'required',
            ],
            'type' => [
                'required',         // 1: feedback, 2: report, 3: deleted reason
            ],
            'content' => [
                'required',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        // check player
        $player = Player::where('id', '=', $request['player_id'])->first();

        $ret = [
            "success" => true,
            "msg" => "Player is not exist.",
        ];

        if(empty($player['email'])) {
            $ret = [
                "success" => false,
                "msg" => "Player is not exist.",
            ];
            return response()->json(['data' => $ret],401);
        }

        // check whether activity has already existed or not
        $activity = Activity::where('player_id', '=', $request['player_id'])
                            ->where('type', '=', $request['type'])
                            ->first();

        if(!empty($activity)) {
            $activity->delete();
        }

        Activity::create($request->input());

        return response()->json(['data' => $ret], $this-> successStatus);
    }
}
