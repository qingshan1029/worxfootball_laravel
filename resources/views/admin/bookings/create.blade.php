@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bookings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="id">{{ trans('cruds.booking.fields.id') }}</label>
                <input class="form-control {{ $errors->has('id') ? 'is-invalid' : '' }}" type="text" name="id" id="id" value="{{ old('id') }}" required>
                @if($errors->has('id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.id_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="match_id">{{ trans('cruds.booking.fields.match_id') }}</label>
                <input class="form-control {{ $errors->has('match_id') ? 'is-invalid' : '' }}" type="text" name="match_id" id="match_id" value="{{ old('match_id') }}" required>
                @if($errors->has('match_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('match_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.match_id_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="player_id">{{ trans('cruds.booking.fields.player_id') }}</label>
                <input class="form-control {{ $errors->has('player_id') ? 'is-invalid' : '' }}" type="text" name="player_id" id="player_id" value="{{ old('player_id') }}" required>
                @if($errors->has('player_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('player_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.player_id_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
{{ csrf_field() }}

