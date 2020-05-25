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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class BookingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = Booking::all();
//        ->pluck('player_id');

        $booking_id = 2;
        $start_time = Match::where('id', '=', $booking_id)->pluck('start_time')->first();
//        dd($start_time);
        $ttt = Booking::where('match_id', '=', $booking_id)->pluck('player_id');
//        dd($ttt);

        $players = Player::whereIn('id', $ttt)->get();
//        dd($players);

        $item = ["booking_id"=>$booking_id, "start_time"=>$start_time, "players"=>$players];
//        dd($item['players']);
//        dd($item);
        return view('admin.bookings.index', compact('bookings', 'item'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bookings.create');
    }

    public function store(StoreBookingRequest $request)
    {
        // save data
        Booking::create($request->input());

        return redirect()->route('admin.bookings.index');
    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->input());

        return redirect()->route('admin.bookings.index');
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $booking->delete();
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

//    private function findNearestRestaurants($today, $latitude, $longitude, $radius = 1500)
//    {
//        /*
//         * using eloquent approach, make sure to replace the "Restaurant" with your actual model name
//         * replace 6371000 with 6371 for kilometer and 3956 for miles
//         */
//        $tomorrow = date('Y-m-d',strtotime($today . "+1 days"));
//        $restaurants = Match::selectRaw("host_photo, host_name, title, start_time, address,
//                        latitude, longitude, rules, players,
//                         ( 6371000 * acos( cos( radians(?) ) *
//                           cos( radians( latitude ) )
//                           * cos( radians( longitude ) - radians(?)
//                           ) + sin( radians(?) ) *
//                           sin( radians( latitude ) ) )
//                         ) AS distance", [$latitude, $longitude, $latitude])
//            ->where([['active', '=', 1],
//                    ['start_time', '>=', $today],
//                    ['start_time', '<', $tomorrow],
//                    ])
//            ->having("distance", "<", $radius)
//            ->orderBy("distance",'asc')
//            ->offset(0)
//            ->limit(20)
//            ->get();
//
//        dd($restaurants);
//        return $restaurants;
//    }
}
