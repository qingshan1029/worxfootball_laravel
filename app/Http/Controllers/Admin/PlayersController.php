<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Booking;
use App\Transaction;
use http\Env\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Player;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPlayerRequest;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PlayersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $players = Player::all();

        return view('admin.players.index', compact('players'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.players.create');
    }

    public function store(StorePlayerRequest $request)
    {
        if( $request->hasFile('photo') ) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/photo/', $filename);
            $request->merge(['photo' => $filename]);

        } else {
            $request->merge(['photo' => 'photo_empty.png']);
        }
        // save data
        $player = Player::create($request->input());

        return redirect()->route('admin.players.index');
    }

    public function edit(Player $player)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.players.edit', compact('player'));
    }

    public function update(UpdatePlayerRequest $request, Player $player)
    {
        if( $request->hasFile('photo') ) {
            $path = 'uploads/photo/' . $player->getAttribute('photo');
//            if (Storage::exists($path)) {
//                Storage::delete($path);
//            }

            if($path != "uploads/photo/photo_empty.png" && File::isFile($path)) {
                File::delete($path);
            }
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/photo/', $filename);
            $request->merge(['photo' => $filename]);

        } else {

        }

        $player->update($request->input());

        return redirect()->route('admin.players.index');
    }

    public function show(Player $player)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transactions = $this->getTransactions($player['id']);

        return view('admin.players.show', compact('player', 'transactions'));
    }

    public function destroy(Player $player)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $path = 'uploads/photo/' . $player->getAttribute('photo');
        if($path != "uploads/photo/photo_empty.png" && File::isFile($path)) {
            File::delete($path);
        }

        // save in Activity table]

        $activity = Activity::where('player_id', '=', $player['id'])
                            ->where('type', '=', 3)
                            ->first();

        if(!empty($activity)) {
            $activity->delete();
        }

        $request = [
            'player_id' => $player['id'],
            'type' => 3,
            'content' => 'My leg is broken.',
        ];

        $activity = Activity::create($request);

        $player->update(['status' => 3]);
        $player->delete();

        return back();
    }

    public function massDestroy(MassDestroyPlayerRequest $request)
    {
        $player = Player::whereIn('id', request('ids'));
        $path = 'uploads/photo/' . $player->getAttribute('photo');
        if($path != "uploads/photo/photo_empty.png" && File::isFile($path)) {
            File::delete($path);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getTransactions($player_id)
    {
//        return
//            Booking::selectRaw("matches.*, bookings.*, bookings.updated_at as payment_time")
//                    ->leftJoin('matches', 'bookings.match_id', '=', 'matches.id')
//                    ->where('player_id', '=', $player_id)
//                    ->orderBy('matches.start_time', 'desc')
//                    ->get();

//        return
//            Booking::selectRaw("matches.host_photo, matches.host_name, matches.address, matches.credits,
//                                matches.start_time, bookings.updated_at as payment_time")
//                ->leftJoin('matches', 'bookings.match_id', '=', 'matches.id')
//                ->where('player_id', '=', $player_id)
//                ->orderBy('matches.start_time', 'desc')
//                ->get();

        return
            Transaction::selectRaw("matches.host_photo, matches.host_name, matches.address, matches.credits,
                                matches.start_time, transactions.*")
                        ->leftJoin('matches', 'transactions.match_id', '=', 'matches.id')
                        ->where('player_id', '=', $player_id)
                        ->orderBy('datetime', 'desc')
                        ->get();
    }
}
