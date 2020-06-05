<?php
namespace App\Http\Controllers\Api;
use App\Booking;
use App\Http\Controllers\Controller;
use App\Transaction;
use Validator;
use Illuminate\Http\Request;

class TransactionAPIController extends Controller
{
    public $successStatus = 200;

    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => [
                'required',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $transactions = Transaction::selectRaw("matches.host_photo, matches.host_name, matches.address, matches.credits,
                                matches.start_time, transactions.*")
                ->leftJoin('matches', 'transactions.match_id', '=', 'matches.id')
                ->where('player_id', '=', $request['player_id'])
                ->orderBy('datetime', 'desc')
                ->get();

        return response()->json(['data' => $transactions], $this-> successStatus);
    }
}
