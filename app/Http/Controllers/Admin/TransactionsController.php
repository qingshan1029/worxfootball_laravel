<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Player;
use App\Transaction;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class TransactionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$transactions = Transaction::all();
        $transactions = Transaction::selectRaw("*")
            ->leftJoin('players', 'player_id', '=', 'players.id')
            ->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.transactions.create');
    }

    public function store($request)
    {
        // save data
        $transactions = Transaction::create($request->input());

        return redirect()->route('admin.transactions.index');
    }

    public function edit(Transaction $transaction)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.transactions.edit', compact('transaction'));
    }

    public function update($request, Transaction $transaction)
    {
        $transaction->update($request->input());

        return redirect()->route('admin.transactions.index');
    }

    public function show(Transaction $transaction)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transaction->delete();

        return back();
    }

    public function massDestroy($request)
    {
        $request = Transaction::whereIn('id', request('ids'));

        $request->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
