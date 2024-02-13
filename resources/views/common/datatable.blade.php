@once

    @push('pre-styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

        {{-- <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
              type="text/css"/> --}}
              {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css"> --}}
              {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css"> --}}

    @endpush
    @push('scripts')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>


        <script src="{{asset('assets/common/buttons.server-side.js')}}"></script>
        @isset($dataTable)
            @if(method_exists($dataTable,'scripts'))
                {!! $dataTable->scripts() !!}
            @elseif(method_exists($dataTable,'html'))
                {!! $dataTable->html()->scripts() !!}
            @endif
        @endif
        @isset($dataTab)
            @if(method_exists($dataTab,'scripts'))
                {!! $dataTab->scripts() !!}
            @elseif(method_exists($dataTab,'html'))
                {!! $dataTab->html()->scripts() !!}
            @endif
        @endif
        <script src="{{asset('assets/common/delete.js')}}"></script>
        <script src="{{asset('assets/common/restore.js')}}"></script>
        <script>
            $(() => {
                $('#filter_search').on('keyup', _.debounce(function () {
                    let table_id = $(this).closest('.index-card').find('table').attr('id');
                    if (table_id && window.LaravelDataTables[table_id]) {
                        window.LaravelDataTables[table_id].draw();
                    }
                }, 500));

                $('.index-card .card-header, .table-filters').on('change', 'input,select', function () {
                    let table_id = $(this).closest('.index-card').find('table').attr('id');
                    if (table_id && window.LaravelDataTables[table_id]) {
                        window.LaravelDataTables[table_id].draw();
                    }
                });
            })
        </script>
    @endpush
@endonce
@include('common.change-status')
