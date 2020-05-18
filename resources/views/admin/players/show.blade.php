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
                            <img src="{{ isset($player) ? "/uploads/photo/$player->photo" : "/uploads/photo/photo_empty.png" }}" id="photo_preview" style="max-height: 160px;width: 160px; margin: 0px;">
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
                <a class="btn btn-default" href="{{ route('admin.players.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection
