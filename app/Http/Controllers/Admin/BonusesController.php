<?php

namespace App\Http\Controllers\Admin;

use App\Bonus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBonusRequest;
use App\Http\Requests\UpdateBonusRequest;
use http\Env\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class BonusesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $bonuses = Bonus::all();

        return view('admin.bonuses.index', compact('bonuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bonuses.create');
    }

    public function store(StoreBonusRequest $request)
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // save data
        $bonus = Match::create($request->input());

        return redirect()->route('admin.bonuses.index');
    }

    public function edit(Bonus $bonus)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bonuses.edit', compact('bonus'));
    }

    public function update(UpdateBonusRequest $request, Bonus $bonus)
    {

        if($request['active'] == null)
            $request['active'] = "0";

        $bonus->update($request->input());

        return redirect()->route('admin.bonuses.index');
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return redirect()->route('admin.bonuses.index');
//        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        return redirect()->route('admin.bonuses.index');
    }

    public function massDestroy(Request $request)
    {
        return redirect()->route('admin.bonuses.index');
    }
}
