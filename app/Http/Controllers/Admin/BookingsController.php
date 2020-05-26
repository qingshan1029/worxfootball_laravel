<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Booking;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Match;
use App\Player;
use Exception;
use http\Env\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class BookingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = Booking::all();
        $bookings = Booking::selectRaw("matches.id as match_id, players.id as player_id, players.first_name, players.last_name,
                        players.birthday, players.photo, players.credits, matches.*, bookings.id")
            ->offset(0)
            ->limit(20)
            ->leftJoin('matches', 'matches.id', '=', 'bookings.match_id')
            ->leftJoin('players', 'players.id', '=', 'bookings.player_id')
            ->get();

        $response = [];
        foreach ($bookings as $booking) {
            if( $booking['first_name'] == null ) // player does not exist
                continue;
            if( $booking['host_name'] == null ) // match does not exist
                continue;

            $players = $this->transformPlayers($booking);
            $matches = $this->transformMatches($booking);
            $response [] = [
                'id' => $booking->id,
                'matches' => $matches,
                'players' => $players,
            ];
        }
//        return response()->json(['data'=>$response], 401);
//        dd($response);

        return view('admin.bookings.index', compact('response'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bookings.create');
    }

    public function store(StoreBookingRequest $request)
    {
//        // save data
//        Booking::create($request->input());

       return $this->createReservations($request);


    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $match = Match::where('id', '=', $booking['match_id'])->first();

        $player = Player::where('id', '=', $booking['player_id'])->first();

        $booking = ["id"=>$booking['id'], "match"=>$match, "player"=>$player ];

        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        //$booking->update($request->input());

        return $this->updateReservation($request, $booking);
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $match = Match::where('id', '=', $booking['match_id'])->first();

        $player = Player::where('id', '=', $booking['player_id'])->first();

        $booking = ["id"=>$booking['id'], "match"=>$match, "player"=>$player ];

        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $booking->delete();

            // decrement reservations in Match and update.
            $match = Match::where('id', '=', $booking['match_id'])->first();
            $reservations = $match['reservations']-1;
            $match['reservations'] = $reservations;
            $match->save();

        } catch (Exception $e) {
        }

        return back();
    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        $booking = Booking::whereIn('id', $request['ids']);
        $booking->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function createReservations($request)
    {
        abort_if(Gate::denies('match_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $params = ['match_id' => $request['match_id'], 'player_id' => $request['player_id']];
        //$params = [$request['match_id'], $request['player_id']];

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
            return response()->json(['error'=>'player is not exist.'], 401);

        if( $match['rules'] <= $match['reservations'])
            return response()->json(['error'=>'booking is full.'], 401);

        $player = Player::where('id', '=', $request['player_id'])->first();

        if( empty($player) )
            return response()->json(['error'=>'match is not exist.'], 401);

        // create a new Booking
        $booking  = new Booking;
        $booking['match_id'] = $match['id'];
        $booking['player_id'] = $player['id'];
        $booking->save();

        // increment reservations in Match and update.
        $reservations = $match['reservations']+1;
        $match['reservations'] = $reservations;
        $match->save();

        return redirect()->route('admin.bookings.index');
    }

    public function updateReservation($request, $booking) {
        abort_if(Gate::denies('match_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'id' => [
                'required',
            ],
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

        $match = Match::where('id', '=', $request['match_id'])->first();

        $player = Player::where('id', '=', $request['player_id'])->first();

        if( empty($match) || empty($player) )
            return response()->json(['error'=>'player or match is not exist.'], 400);

        $tempBooking = Booking::where('id', '=', $request['id'])->first();

        if( empty($tempBooking) )
            return response()->json(['error'=>'Booking is is not exist.'], 403);

        $ret = Booking::where('id', '=', $request['id'])->first()->update($request->input());

        if( $ret == false )
            return response()->json(['error'=>'Failed to update your reservation'], 405);

        return redirect()->route('admin.bookings.index');
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    public function transformPlayers($request) {
        return [
            'id' => $request->player_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'photo' => $request->photo,
        ];
    }
    public function transformMatches($request) {
        return [
            'match_id' => $request->match_id,
            'host_photo' => $request->host_photo,
            'host_name' => $request->host_name,
            'title' => $request->title,
            'start_time' => $request->start_time,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'rules' => $request->rules,
            'reservations' => $request->reservations,
            'credits' => $request->credits,
        ];
    }
}
