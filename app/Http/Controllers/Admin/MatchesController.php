<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Match;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMatchRequest;
use App\Http\Requests\StoreMatchRequest;
use App\Http\Requests\UpdateMatchRequest;
use http\Env\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MatchesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('match_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $matches = Match::all();

        $matches = Match::orderBy('start_time', 'desc')->get();

        return view('admin.matches.index', compact('matches'));
    }

    public function create()
    {
        abort_if(Gate::denies('match_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.matches.create');
    }

    public function store(StoreMatchRequest $request)
    {
        abort_if(Gate::denies('match_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if( $request['rules'] < $request['reservations'] )
            abort_if(true, Response::HTTP_FORBIDDEN, 'reservations must less than rules');

        if( $request->hasFile('host_photo') ) {
            $file = $request->file('host_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/host/', $filename);
            $request->merge(['host_photo' => $filename]);
        } else {
            $request->merge(['host_photo' => 'host_photo_empty.png']);
        }

        // save data
        $matches = Match::create($request->input());

        return redirect()->route('admin.matches.index');
    }

    public function edit(Match $match)
    {
        abort_if(Gate::denies('match_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.matches.edit', compact('match'));
    }

    public function update(UpdateMatchRequest $request, Match $match)
    {
        if( $request['rules'] < $request['reservations'] )
            abort_if(true, Response::HTTP_FORBIDDEN, 'reservations must less than rules');

        if( $request->hasFile('host_photo') ) {
            $path = 'uploads/host/' . $match->getAttribute('host_photo');
//            if (Storage::exists($path)) {
//                Storage::delete($path);
//            }

            if($path != "uploads/host/host_photo_empty.png" && File::isFile($path)) {
                File::delete($path);
            }

            $file = $request->file('host_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/host/', $filename);
            $request->merge(['host_photo' => $filename]);
        } else {

        }

        //$this->getMatches($request);

        $match->update($request->input());

        return redirect()->route('admin.matches.index');
    }

    public function show(Match $match)
    {
        abort_if(Gate::denies('match_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.matches.show', compact('match'));
    }

    public function destroy(Match $match)
    {
        abort_if(Gate::denies('match_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $path = 'uploads/host/' . $match->getAttribute('host_photo');
        if($path != "uploads/host/host_photo_empty.png" && File::isFile($path)) {
            File::delete($path);
        }

        $match->delete();

        return back();
    }

    public function massDestroy(MassDestroyMatchRequest $request)
    {
//        Match::whereIn('id', request('ids'))->delete();

        $match = Match::whereIn('id', request('ids'));
        $path = 'uploads/host/' . $match->getAttribute('host_photo');
        if($path != "uploads/host/host_photo_empty.png" && File::isFile($path)) {
            File::delete($path);
        }

        $match->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function getMatches($request)
    {
        abort_if(Gate::denies('match_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

//        $validator = Validator::make($request->all(), [
//                'start_time' => [
//                'required',
//            ],
//                    'latitude' => [
//                'required',
//            ],
//                    'longitude' => [
//                'required',
//            ],
//                    'radius' => [
//                'required',
//            ],
//        ]);
//
//        if ($validator->fails()) {
//            //return response()->json(['error'=>$validator->errors()], 401);
//            return response(null, Response::HTTP_NO_CONTENT);
//        }

        $request = ["start_time"=>"2020-05-20 10:00:00", "latitude" => '53.2535714', "longitude" => '-1.4257437',
        "radius" => "1500"];
        $today = date("Y-m-d", strtotime($request['start_time']));
        $matches = $this->findNearestMatches($today, $request['latitude'], $request['longitude'], $request['radius']);

        dd($matches);

        return response(null, Response::HTTP_NO_CONTENT);
    }

//    private function findNearestMatches($today, $latitude, $longitude, $radius = 1500)
//    {
//        /*
//         * using eloquent approach, make sure to replace the "Restaurant" with your actual model name
//         * replace 6371000 with 6371 for kilometer and 3956 for miles
//         */
//        $tomorrow = date('Y-m-d',strtotime($today . "+1 days"));
//        $matches = Match::selectRaw("matches.id as match_id, bookings.player_id as player_id, players.*, matches.*,
//                         ( 6371000 * acos( cos( radians(?) ) *
//                           cos( radians( latitude ) )
//                           * cos( radians( longitude ) - radians(?)
//                           ) + sin( radians(?) ) *
//                           sin( radians( latitude ) ) )
//                         ) AS distance", [$latitude, $longitude, $latitude])
//            ->where([['active', '=', 1],
//                ['start_time', '>=', $today],
//                ['start_time', '<', $tomorrow],
//            ])
//            ->having("distance", "<", $radius)
//            ->orderBy("distance",'asc') // oder by nearest neighbour
//            ->offset(0)
//            ->limit(20)
//            ->leftJoin('bookings', 'matches.id', '=', 'bookings.match_id')
//            ->leftJoin('players', 'players.id', '=', 'bookings.player_id')
//            ->get();
//
//        return $matches;
//    }

    private function findNearestMatches($today, $latitude, $longitude, $radius = 1500)
    {
        /*
         * using eloquent approach, make sure to replace the "Restaurant" with your actual model name
         * replace 6371000 with 6371 for kilometer and 3956 for miles
         */
        $tomorrow = date('Y-m-d',strtotime($today . "+1 days"));
        $matches = Match::selectRaw("matches.id as match_id, bookings.player_id as player_id, players.*, matches.*,
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
            ->leftJoin('bookings', 'matches.id', '=', 'bookings.match_id')
            ->leftJoin('players', 'players.id', '=', 'bookings.player_id')
            ->get();

        return $matches;
    }
}
