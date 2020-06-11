@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.bonus.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.bonuses.update", $bonus['id']) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required control-label" for="from_date">{{ trans('cruds.bonus.fields.from_date') }}</label>
                    <input class="form-control datetime" type="text" name="from_date" id="from_date" value="{{ old('from_date', $bonus->from_date) }}" required>
                    <p class="help-block"></p>
                    @if($errors->has('from_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('from_date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.bonus.fields.from_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required control-label" for="to_date">{{ trans('cruds.bonus.fields.to_date') }}</label>
                    <input class="form-control datetime" type="text" name="to_date" id="to_date" value="{{ old('to_date', $bonus->to_date) }}" required>
                    <p class="help-block"></p>
                    @if($errors->has('to_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('to_date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.bonus.fields.to_date_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="amount">{{ trans('cruds.bonus.fields.amount') }}</label>
                    <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $bonus['amount']) }}" required>
                    @if($errors->has('amount'))
                        <div class="invalid-feedback">
                            {{ $errors->first('amount') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.bonus.fields.amount_helper') }}</span>
                </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ $bonus->active || old('active', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">{{ trans('cruds.bonus.fields.active') }}</label>
                </div>
                @if($errors->has('active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bonus.fields.active_helper') }}</span>
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
