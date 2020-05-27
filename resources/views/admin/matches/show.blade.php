@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.match.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.matches.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.match.fields.host_photo') }}
                        </th>
                        <td>
{{--                            {{ $match->host_photo }}--}}
                            <img src="{{ isset($match) ? "/uploads/host/$match->host_photo" : old('host_photo') }}" id="host_photo_preview" class="avatar-large" style="margin: 0px;">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.match.fields.host_name') }}
                        </th>
                        <td>
                            {{ $match->host_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.match.fields.title') }}
                        </th>
                        <td>
                            {{ $match->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.match.fields.start_time') }}
                        </th>
                        <td>
                            {{ $match->start_time }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.match.fields.address') }}
                        </th>
                        <td>
                            {{ $match->address }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.match.fields.rules') }}
                        </th>
                        <td>
                            {{ $match->rules }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.match.fields.reservations') }}
                        </th>
                        <td>
                            {{ $match->reservations }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.match.fields.credits') }}
                        </th>
                        <td>
                            {{ $match->credits }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.match.fields.active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $match->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.matches.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.player.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.player.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.player.fields.first_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.player.fields.last_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.player.fields.birthday') }}
                    </th>
                    <th>
                        {{ trans('cruds.player.fields.photo') }}
                    </th>
                    <th>
                        {{ trans('cruds.player.fields.credits') }}
                    </th>
                    <th>

                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($bookingPlayers as $key => $player)
                    <tr data-entry-id="{{ $player->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $player->email ?? '' }}
                        </td>
                        <td>
                            {{ $player->first_name ?? '' }}
                        </td>
                        <td>
                            {{ $player->last_name ?? '' }}
                        </td>
                        <td>
                            {{ date('Y-m-d', strtotime($player->birthday)) ?? '' }}
                        </td>
                        <td>
                            {{--                                {{ $player->photo ?? '' }}--}}
                            <img src="{{ isset($player) ? "/uploads/photo/$player->photo" : "/uploads/photo/photo_empty.png" }}" id="photo_preview" alt="Avatar" class="avatar-small" style="margin-top: 0px">
                        </td>
                        <td>
                            {{ $player->credits ?? '' }}
                        </td>
                        <td>
                            @can('user_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.players.show', $player->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan

                            @can('user_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.players.edit', $player->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan

                            @can('user_delete')
                                <form action="{{ route('admin.players.destroy', $player->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            @endcan

                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
