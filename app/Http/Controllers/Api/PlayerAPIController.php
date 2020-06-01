<?php
namespace App\Http\Controllers\Api;
use App\Booking;
use App\Http\Controllers\Controller;
use App\Player;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
class PlayerAPIController extends Controller
{
    public $successStatus = 200;
    public function login() {
        $request = ['email' => request('email'), 'password' => request('password')];

        $validator = Validator::make($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails($request)) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $player = Player::where('email', $request['email'])->first();

        if( $player != null ) {    // email successful
            if (Hash::check($request['password'], $player['password'])) {   // password successful
                return response()->json(['user' => $player], $this-> successStatus);
            }
        }

        return response()->json(['error'=>'Unauthenticated player'], 401);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => [
                'required',
                'unique:players',
            ],
            'password' => [
                'required',
            ],
            'first_name' => [
                'required',
            ],
            'last_name' => [
                'required',
            ],
            'birthday' => [
                'required',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        if( $request->hasFile('photo') ) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/photo/', $filename);
            $request->merge(['photo' => $filename]);

        } else {
            $request->merge(['photo' => 'photo_empty.png']);
        }

        $player = Player::where('email','=',$request['email']);
        if( $player->count()) {
            return response()->json(['error'=>'The email exist already.'], 401);
        }

        $player = Player::create($request->all());
        $success['email'] =  $player->email;
        return response()->json(['user'=>$player], $this-> successStatus);
    }

    public function players()
    {
        $players = Player::all();
        return response()->json(['user' => $players], $this-> successStatus);
    }

    public function getTransactions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => [
                'required',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

//        return
//            Booking::selectRaw("matches.*, bookings.*, bookings.updated_at as payment_time")
//                    ->leftJoin('matches', 'bookings.match_id', '=', 'matches.id')
//                    ->where('player_id', '=', $player_id)
//                    ->orderBy('matches.start_time', 'desc')
//                    ->get();

          $transactions = Booking::selectRaw("matches.host_photo, matches.host_name, matches.address, matches.credits,
                                matches.start_time, bookings.updated_at as payment_time")
                ->leftJoin('matches', 'bookings.match_id', '=', 'matches.id')
                ->where('player_id', '=', $request['player_id'])
                ->orderBy('matches.start_time', 'desc')
                ->get();
          return response()->json(['data' => $transactions], $this-> successStatus);
    }
}
