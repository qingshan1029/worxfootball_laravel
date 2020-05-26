<?php

namespace App\Http\Controllers;

use App\Match;

class HomeController extends Controller
{
    public function index()
    {
        $matches = Match::all();

        $mapMatches = $matches->makeHidden(['active', 'created_at', 'updated_at', 'deleted_at', 'players', 'rules']);

        $latitude = $matches->count() ? $matches->average('latitude') : 51.5073509;
        $longitude = $matches->count() ? $matches->average('longitude') : -0.12775829999998223;


        return view('home', compact('mapMatches', 'latitude', 'longitude'));
    }

//    public function show(Shop $shop)e
//    {
//        $shop->load(['categories', 'days']);
//
//        return view('shop', compact('shop'));
//    }
}
