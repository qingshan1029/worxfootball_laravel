@extends('layouts.admin')
@section('content')
{{--@can('user_create')--}}
{{--    <div style="margin-bottom: 10px;" class="row">--}}
{{--        <div class="col-lg-12">--}}
{{--            <a class="btn btn-success" href="{{ route("admin.bookings.create") }}">--}}
{{--                {{ trans('global.add') }} {{ trans('cruds.booking.title_singular') }}--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endcan--}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.booking.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.match_start_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.match_address') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.player_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.operations') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($response as $key => $bookings)
                        <tr data-entry-id="{{ $bookings['id'] }}">
                            <td>

                            </td>
                            <td>
                                {{ $bookings['matches']['start_time'] ?? '' }}
                            </td>
                            <td>
                                {{ $bookings['matches']['address'] ?? '' }}
                            </td>
                            <td>
                                {{ $bookings['players']['email'] ?? '' }}
                            </td>
                            <td>
                                {{ $bookings['players']['first_name'] ?? '' }}  {{ $bookings['players']['last_name'] ?? ''}}
                            </td>
                            <td>
{{--                                @can('user_show')--}}
{{--                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.bookings.show', $bookings['id']) }}">--}}
{{--                                        {{ trans('global.view') }}--}}
{{--                                    </a>--}}
{{--                                @endcan--}}

{{--                                @can('user_edit')--}}
{{--                                    <a class="btn btn-xs btn-info" href="{{ route('admin.bookings.edit', $bookings['id']) }}">--}}
{{--                                        {{ trans('global.edit') }}--}}
{{--                                    </a>--}}
{{--                                @endcan--}}

                                @can('user_delete')
                                    <form action="{{ route('admin.bookings.destroy', $bookings['id']) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bookings.massDestroy') }}",
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
  $('.datatable-User:not(.ajaxTable)').DataTable()
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
