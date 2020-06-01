@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.match.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.matches.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="host_photo" class="form-control-label">{{trans('cruds.match.fields.host_photo')}}</label>
                <input id="host_photo" type="file" class="form-control{{ $errors->has('host_photo') ? ' is-invalid' : '' }}" name="host_photo"
                       value="/uploads/host/host_photo_empty.png" accept="image/*">
                <img src="/uploads/host/host_photo_empty.png" id="host_photo_preview" class="avatar-medium" style="margin-top: 10px;">
                @if($errors->has('host_photo'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('host_photo') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label class="required" for="host_name">{{ trans('cruds.match.fields.host_name') }}</label>
                <input class="form-control {{ $errors->has('host_name') ? 'is-invalid' : '' }}" type="text" name="host_name" id="host_name" value="{{ old('host_name', '') }}" required>
                @if($errors->has('host_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('host_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.match.fields.host_name_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required control-label" for="start_time">{{ trans('cruds.match.fields.start_time') }}</label>
                <input class="form-control datetime" type="text" name="start_time" id="start_time " required>
                <p class="help-block"></p>
                @if($errors->has('start_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.match.fields.start_time_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.match.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.match.fields.title_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="rules">{{ trans('cruds.match.fields.rules') }}</label>
                <input class="form-control {{ $errors->has('rules') ? 'is-invalid' : '' }}" type="text" name="rules" id="rules" value="{{ old('rules', '') }}" required>
                @if($errors->has('rules'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rules') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.match.fields.rules_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="max_players">{{ trans('cruds.match.fields.max_players') }}</label>
{{--                <textarea class="form-control {{ $errors->has('rules') ? 'is-invalid' : '' }}" name="rules" id="rules" required>{{ old('description') }}</textarea>--}}
{{--                @if($errors->has('rules'))--}}
{{--                    <div class="invalid-feedback">--}}
{{--                        {{ $errors->first('rules') }}--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.match.fields.rules_helper') }}</span>--}}


                <div class="form-inline">
                    <select class="custom-select my-0 mr-sm-2" name="max_players">
                        @foreach(range(6, 22, 2) as $max_players)
                            <option
                                value="{{$max_players}}">{{$max_players}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label for="address">{{ trans('cruds.match.fields.address') }}</label>
                <input class="form-control map-input {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address') }}" required>
                <input type="hidden" name="latitude" id="address-latitude" value="{{ old('latitude') ?? '0' }}" />
                <input type="hidden" name="longitude" id="address-longitude" value="{{ old('longitude') ?? '0' }}" />
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.match.fields.address_helper') }}</span>
            </div>

            <div id="address-map-container" class="mb-2" style="width:100%;height:400px; ">
                <div style="width: 100%; height: 100%" id="address-map"></div>
            </div>

{{--            <label>{{ trans('cruds.match.fields.reservations') }}</label>--}}
{{--            <div class="form-inline">--}}
{{--                <select class="custom-select my-0 mr-sm-2" name="reservations">--}}
{{--                    @foreach(range(0, 22) as $reservations)--}}
{{--                        <option--}}
{{--                            value="{{$reservations}}">{{$reservations}}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}

            <div class="form-group">
                <label class="required control-label" for="credits">{{ trans('cruds.match.fields.credits') }}</label>
                <input class="form-control" type="number" name="credits" id="credits " required>
                <p class="help-block"></p>
                @if($errors->has('credits'))
                    <div class="invalid-feedback">
                        {{ $errors->first('credits') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.match.fields.credits_helper') }}</span>
            </div>

{{--            <div class="form-group">--}}
{{--                <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">--}}
{{--                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', 0) == 1 ? 'checked' : '' }}>--}}
{{--                    <label class="form-check-label" for="active">{{ trans('cruds.match.fields.active') }}</label>--}}
{{--                </div>--}}
{{--                @if($errors->has('active'))--}}
{{--                    <div class="invalid-feedback">--}}
{{--                        {{ $errors->first('active') }}--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.match.fields.active_helper') }}</span>--}}
{{--            </div>--}}
            <div class="form-group my-4">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')

<script src="https://maps.googleapis.com/maps/api/js?key={{'AIzaSyANxtVBChtAr2McEkTXjZIMZ4vjjidNkOQ'}}&libraries=places&callback=initialize&language=en&region=GB" async defer></script>

<script src="/js/mapInput.js"></script>

<script>
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }

</script>

<script>
    $('#host_photo').change(function () {
        if(this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#host_photo_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>

@endsection
