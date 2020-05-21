<?php

namespace App\Http\Controllers\Admin;

use App\Match;
use App\Player;
use App\User;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index()
    {
        abort_if(Gate::denies('match_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $players = Player::all();
        $matches = Match::all();
        $users = User::all();

        $player_count = count($players);
        $match_count = count($matches);
        $user_count = count($users);
        $info['player_count'] = $player_count;
        $info['match_count'] = $match_count;
        $info['user_count'] = $user_count;

        return view('admin.home',  compact('info'));
    }
}
