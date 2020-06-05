<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Activity;
use App\Http\Requests\MassDestroyActivityRequest;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ActivitiesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activities = Activity::all();

        return view('admin.activities.index', compact('activities'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.activities.create');
    }

    public function store(StoreActivityRequest $request)
    {
       // save data
        $activities = Activity::create($request->input());

        return redirect()->route('admin.activities.index');
    }

    public function edit(Activity $activity)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.activities.edit', compact('activity'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $activity->update($request->input());

        return redirect()->route('admin.activities.index');
    }

    public function show(Activity $activity)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.activities.show', compact('activity'));
    }

    public function destroy(Activity $activity)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activity->delete();

        return back();
    }

    public function massDestroy(MassDestroyActivityRequest $request)
    {
        $request = Activity::whereIn('id', request('ids'));

        $request->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
