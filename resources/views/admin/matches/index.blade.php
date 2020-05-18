@extends('layouts.admin')
@section('content')
@can('match_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.matches.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.match.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.match.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Match dt-select">
                <thead>
                    <tr>
                        @can('match_delete')
                            <th></th>
                        @endcan

                        <th>
                            {{ trans('cruds.match.fields.host_photo') }}
                        </th>

                        <th>
                            {{ trans('cruds.match.fields.host_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.match.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.match.fields.start_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.match.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.match.fields.rules') }}
                        </th>
                        <th>
                            {{ trans('cruds.match.fields.players') }}
                        </th>
                        <th>
                            {{ trans('cruds.match.fields.active') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matches as $key => $match)
                        <tr data-entry-id="{{ $match->id }}">
                            @can('match_delete')
                                <td></td>
                            @endcan

                            <td>
                                <img src="{{ isset($match) ? "/uploads/host/$match->host_photo" : old('host_photo') }}" id="photo_preview" style="max-height: 40px;width: 40px; margin: 0px;">
                            </td>

                            <td>
                                {{ $match->host_name ?? '' }}
                            </td>

                            <td>
                                {{ $match->title ?? '' }}
                            </td>

                            <td>
                                {{ $match->start_time ?? '' }}
                            </td>

                            <td>
                                {{ $match->address ?? '' }}
                            </td>

                            <td>
                                {{ $match->rules ?? '' }}
                            </td>

                            <td>
                                {{ $match->players ?? '' }}
                            </td>

                            <td>
                                <span style="display:none">{{ $match->active ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $match->active ? 'checked' : '' }}>
                            </td>

                            <td>
                                @can('match_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.matches.show', $match->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('match_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.matches.edit', $match->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('match_delete')
                                    <form action="{{ route('admin.matches.destroy', $match->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                @can('match_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.matches.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                    }
                }
            }

dtButtons.push(deleteButton)
@endcan

$.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 10,
});
$('.datatable-Match:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
