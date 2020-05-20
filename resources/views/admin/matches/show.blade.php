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
                            {{ trans('cruds.match.fields.players') }}
                        </th>
                        <td>
                            {{ $match->players }}
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
@endsection
