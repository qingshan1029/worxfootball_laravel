<?php
namespace App\Http\Controllers\Api;
use App\Booking;
use App\Http\Controllers\Controller;
use App\Match;
use App\Player;
use App\Transaction;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Illuminate\Http\Request;

class BookingAPIController extends Controller
{
    public $successStatus = 200;

    public function createReservations(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'match_id' => [
                'required',
            ],
            'player_id' => [
                'required',
            ],
        ]);


        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        // check to exist already in Booking
        $tempBooking = Booking::where('match_id', '=', $request['match_id'])
            ->where('player_id', '=', $request['player_id'])
            ->first();
        if( !empty($tempBooking) )
            return response()->json(['error'=>'you have already reserved.'], 400);

        $match = Match::where('id', '=', $request['match_id'])
            ->first();

        if( empty($match) )
            return response()->json(['error'=>'match is not exist.'], 401);

        if( $match['max_players'] <= $match['reservations'])
            return response()->json(['error'=>'booking is full.'], 401);

        $player = Player::where('id', '=', $request['player_id'])->first();

        if( empty($player) )
            return response()->json(['error'=>'player is not exist.'], 401);

        // check my credits
        if($player['credits'] < $match['credits'])
            return response()->json(['error'=>'Your credit is not enough. Please do stripe payment.'], 401);

        // create a new Booking
        $booking  = new Booking;
        $booking['match_id'] = $match['id'];
        $booking['player_id'] = $player['id'];
        $booking->save();

        // increment reservations in Match and update.
        $reservations = $match['reservations']+1;
        $match['reservations'] = $reservations;
        $match->save();

        // decrease amount in your transaction
        $info = [
            'player_id' => $player['id'],
            'match_id' => $match['id'],         // valid in case of reservation
            'datetime' => now(),
            'event_name' => 'reserved',
            'amount' => -$match['credits'],      // virtual money (to decrease, put minus symbol)
            'credit' => 0,                      // none
        ];

        // create one new transaction
        Transaction::create($info);

        // calculate sum the amount(virtual) to all transactions by player_id
        $purchases = Transaction::where('player_id', '=', $player['id'])
            ->sum('amount');

        // update credits of player by player_id
        $player = Player::where('id', '=', $player['id'])->first();
        $player->update(['credits' => $purchases]);

        return response()->json(['data' => "success"], $this-> successStatus);
    }
}
