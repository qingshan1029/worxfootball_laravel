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
                            {{ $player->credits }}
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
        My transactions
    </div>
    @foreach($transactions as $key=>$transaction)
        <div class="card-body" style="align-self: center; width: 600px">
            <div class="form-group">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr style="background: rgba(255, 128, 0, 1)">
                        <th class="col-lg-12" style="width: 200px">
                            {{--                            {{ trans('cruds.player.fields.email') }}--}}
                            Host Name
                        </th>
                        <td>
                            {{ $transaction->host_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Start Time
                        </th>
                        <td>
                            {{ $transaction->start_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Location
                        </th>
                        <td>
                            {{ $transaction->address }}
                        </td>
                    </tr>
                    @if(Date($transaction->start_time) > now())
                        <tr >
                            <th>
                                Payment date
                            </th>
                            <td class="row m-0">
                                <div class="col-lg-8">
                                    {{ $transaction->payment_time }}
                                </div>
                                <div class="col-lg-4" style="background: rgba(200,0,0,1); color: white; text-align: center">
                                    Reserve
                                </div>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <th>
                                Payment date
                            </th>
                            <td class="row m-0">
                                <div class="col-lg-8">
                                    {{ $transaction->payment_time }}
                                </div>
                                <div class="col-lg-4">
                                    Closed
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    @endif
                </table>
            </div>
        </div>
    @endforeach
</div>

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
