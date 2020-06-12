@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.player.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.players.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.player.fields.email') }}
                        </th>
                        <td>
                            {{ $player->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.player.fields.first_name') }}
                        </th>
                        <td>
                            {{ $player->first_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.player.fields.last_name') }}
                        </th>
                        <td>
                            {{ $player->last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.player.fields.birthday') }}
                        </th>
                        <td>
                            {{ date('Y-m-d', strtotime($player->birthday)) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.player.fields.photo') }}
                        </th>
                        <td>
{{--                            {{ $player->photo }}--}}
                            <img src="{{ isset($player) ? "/uploads/photo/$player->photo" : "/uploads/photo/photo_empty.png" }}" id="photo_preview" alt="Avatar" class="avatar-large" style="margin: 0px">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.player.fields.credits') }}
                        </th>
                        <td>
                            £{{ $player->credits }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" style="color: white" id="showing">
                    Show transactions
                </a>
            </div>
        </div>
    </div>
</div>
<div class="card" id = 'transaction' style="display: none">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.player.title') }}
    </div>
    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover datatable datatable-User">
            <thead>
            <tr>
                <th width="10">

                </th>
                <th>
                    {{ trans('cruds.transaction.fields.datetime') }}
                </th>
                <th>
                    {{ trans('cruds.transaction.fields.event_name') }}
                </th>
                <th>
                    {{ trans('cruds.transaction.fields.description') }}
                </th>
                <th>
                    {{ trans('cruds.transaction.fields.event') }}
                </th>
                <th>
                    {{ trans('cruds.transaction.fields.amount') }}
                </th>
{{--                <th>--}}
{{--                    {{ trans('cruds.transaction.fields.credit') }}--}}
{{--                </th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($transactions as $key => $transaction)
                <tr data-entry-id="{{ $transaction->id }}">
                    <td>

                    </td>
                    <td>
                        {{ $transaction->datetime ?? '' }}
                    </td>
                    <td>
                        {{ $transaction->event_name ?? '' }}
                    </td>
                    <td>
                        {{ $transaction->description ?? '' }}
                    </td>
                    @if($transaction->event_name == 'reserved' && Date($transaction->start_time) > now())
                        <td class="row m-0" style="border: none; padding-left: 0">
                            <div class="col-lg-8">
                                {{ $transaction->address ?? '' }}
                            </div>
                            <div class="col-lg-4" style="background: rgb(255,165,139); color: #545454; text-align: center;">
                                {{ $transaction->start_time ?? '' }}
                            </div>
                        </td>
                    @elseif($transaction->event_name == 'reserved')
                        <td class="row m-0" style="border: none; padding-left: 0">
                            <div class="col-lg-8">
                                {{ $transaction->address ?? '' }}
                            </div>
                            <div class="col-lg-4" style="background: rgb(91,174,227); color: white; text-align: center;">
                                {{ $transaction->start_time ?? '' }}
                            </div>
                        </td>
                    @else
                        <td>
                            {{ $transaction->event_name ?? '' }}
                        </td>
                    @endif
                    <td>
                        £{{ $transaction->amount ?? '' }}
                    </td>
{{--                    <td>--}}
{{--                        {{ $transaction->credit ?? '' }}--}}
{{--                    </td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{--<div class="card" id = 'transaction' style="display: none">--}}
{{--    <div class="card-header">--}}
{{--        My transactions--}}
{{--    </div>--}}
{{--    @foreach($transactions as $key=>$transaction)--}}
{{--        <div class="card-body" style="align-self: center; width: 600px">--}}
{{--            <div class="form-group">--}}
{{--                <table class="table table-bordered table-striped">--}}
{{--                    <tbody>--}}
{{--                    <tr style="background: rgba(255, 128, 0, 1)">--}}
{{--                        <th class="col-lg-12" style="width: 200px">--}}
{{--                            --}}{{--                            {{ trans('cruds.player.fields.email') }}--}}
{{--                            Host Name--}}
{{--                        </th>--}}
{{--                        <td>--}}
{{--                            {{ $transaction->host_name }}--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <th>--}}
{{--                            Start Time--}}
{{--                        </th>--}}
{{--                        <td>--}}
{{--                            {{ $transaction->start_time }}--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <th>--}}
{{--                            Location--}}
{{--                        </th>--}}
{{--                        <td>--}}
{{--                            {{ $transaction->address }}--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    @if(Date($transaction->start_time) > now())--}}
{{--                        <tr >--}}
{{--                            <th>--}}
{{--                                Payment date--}}
{{--                            </th>--}}
{{--                            <td class="row m-0">--}}
{{--                                <div class="col-lg-8">--}}
{{--                                    {{ $transaction->payment_time }}--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-4" style="background: rgba(200,0,0,1); color: white; text-align: center">--}}
{{--                                    Reserve--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @else--}}
{{--                        <tr>--}}
{{--                            <th>--}}
{{--                                Payment date--}}
{{--                            </th>--}}
{{--                            <td class="row m-0">--}}
{{--                                <div class="col-lg-8">--}}
{{--                                    {{ $transaction->payment_time }}--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-4">--}}
{{--                                    Closed--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    </tbody>--}}
{{--                    @endif--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endforeach--}}
{{--</div>--}}

@endsection
@section('scripts')
    <script>
        let bShow = false;
        $('#showing').click(function () {
            bShow = !bShow;
            if(bShow) {
                $('#transaction').show();
                $('#showing').text('Hide');
            }
            else {
                $('#transaction').hide();
                $('#showing').text('Show transactions');
            }
        });
    </script>
@endsection
