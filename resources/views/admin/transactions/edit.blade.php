@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.activity.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.activities.update", $activity->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="player_id">{{ trans('cruds.activity.fields.player_id') }}</label>
                <input class="form-control {{ $errors->has('player_id') ? 'is-invalid' : '' }}" type="number" name="player_id" id="player_id" value="{{ old('player_id', $activity->player_id) }}" required>
                @if($errors->has('player_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('player_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.player_id_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.activity.fields.type') }}</label>
                <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="number" name="type" id="type" value="{{ old('type', $activity->type) }}" required>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="content">{{ trans('cruds.activity.fields.content') }}</label>
                <input class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" type="text" name="content" id="content" value="{{ old('content', $activity->content) }}" required>
                @if($errors->has('content'))
                    <div class="invalid-feedback">
                        {{ $errors->first('content') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.content_helper') }}</span>
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
