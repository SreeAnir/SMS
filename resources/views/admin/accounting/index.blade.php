@extends('layouts.admin.app')
@section('title', 'List Income and expense')

@section('content')
    @include('admin.accounting.partials.chart')

    <x-index-card>

        <x-slot:toolbar>

            <div class="d-flex justify-content-between" data-kt-user-table-toolbar="base">

                <div class="d-flex flex-row">
                    <div class="col-md-6 px-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="income_checkbox">
                            <label class="form-check-label text-success" for="income">
                                Income
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6  px-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="expense_checkbox">
                            <label class="form-check-label text-danger" for="expense">
                                Expense
                            </label>
                        </div>
                    </div>
                </div>

                <div class="border bg-light px-2">
                    <span>Net Revenue : <b class="{{ @$stats->net_revenue < 0 ? ' text-danger ' : ' text-success ' }}">
                            {{ @$stats->net_revenue }} AED</b> | </span>
                    <span>Net Income : <b> {{ @$stats->total_income }} AED</b> | </span>
                    <span>Net Expense : <b> {{ @$stats->total_expense }} AED</b></span> 
                </div>

                <a href="{{ route('accounting.create') }}" type="button" class="btn btn-primary btn-lg">
                    @lang('+ Income and expense')
                </a>
                <a id="export_btn" href="{{ route('export.accounting') }}" type="button" class="btn btn-secondary btn-lg ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                      </svg>  @lang('Export')
                </a>

            </div>
        </x-slot:toolbar>

        <x-slot:filter id="users_filter">
            @include('admin.accounting.partials.filter')
        </x-slot:filter>

        <x-slot:table>
            {!! $dataTable->table() !!}
        </x-slot:table>
    </x-index-card>

@endsection
@include('common.datatable')

<!-- Button trigger modal -->

@include('admin.accounting.partials.view')
@include('admin.accounting.partials.edit')



@push('scripts')
    <script src="{{ asset('/assets/libs/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('/assets/libs/flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('/assets/libs/flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('/assets/libs/flot/jquery.flot.crosshair.js') }}"></script>
    <script src="{{ asset('/assets/libs/chart/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/chart/matrix.charts.js') }}"></script>
    <script src="{{ asset('/assets/libs/chart/jquery.flot.pie.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>

    <script>
        var data_expense = @json($pie_data_expense);
        console.log(data_expense);
        var data_income = @json($pie_data_income);
        console.log(data_income);
        $('#charts').hide();
        if (data_income.length > 0) {
            $('#charts').show();

            $('#piechart-income').css({
                'width': '90%',
                'min-height': '150px'
            });
            var my_chart2 = $.plot('#piechart-income', data_income, {
                series: {
                    pie: {
                        innerRadius: 0.5,
                        //             label: {
                        //     show: true
                        // },
                        show: true,
                        highlight: {
                            opacity: 0.25
                        },
                        stroke: {
                            color: '#fff',
                            width: 2
                        },
                        startAngle: 2
                    }
                },
                colors: ["#FF5733", "#0CCE99", "#7B1F9D", "#EDBC06", "#990B0B", '#1A5F6B', '#ECDC6A', '#84FCF1',
                    '#476BF3', '#DAF7A6', '#9BEE77', '#9BEE77'
                ],
                legend: {
                    show: true,
                    position: "ne",
                    labelBoxBorderColor: null,
                    margin: [-30, 15] //some offsetting
                },
                grid: {
                    hoverable: true,
                    clickable: true
                }
            })
        } else {
            $('#piechart-income').html("No Income Added");
        }


        if (data_expense.length > 0) {
            $('#charts').show();

            $('#piechart-expense').css({
                'width': '90%',
                'min-height': '150px'
            });
            var my_chart1 = $.plot('#piechart-expense', data_expense, {
                series: {
                    pie: {
                        show: true,
                        innerRadius: 0.5,
                        // label: {
                        // show: true
                        // },
                        highlight: {
                            opacity: 0.25
                        },
                        stroke: {
                            color: '#fff',
                            width: 2
                        },
                        startAngle: 2
                    }
                },
                colors: ["#FF5733", "#0CCE99", "#7B1F9D", "#EDBC06", "#990B0B", '#1A5F6B', '#ECDC6A', '#84FCF1',
                    '#476BF3', '#DAF7A6', '#9BEE77', '#9BEE77'
                ],
                legend: {
                    show: true,
                    position: "ne",
                    labelBoxBorderColor: null,
                    margin: [-30, 15] //some offsetting
                },
                grid: {
                    hoverable: true,
                    clickable: true
                }
            })
        } else {
            $('#piechart-expense').html("No Expense Added");
        }

        var BaseUrl = "{{ url('/') }}";

        $(document).ready(function() {
            $('.error_pop').hide();
            $(document).on('click', '#update_accounting', function(e) {
                $('.error_pop').hide();
                if ($('#edit_category_id').val() == "" || parseFloat($('#edit_amount').val()) < 0 || $(
                        '#edit_location_id').val() == "") {
                    $('.error_pop').show();
                    return false;
                }
                if ($('#acc_id').val() == "") {
                    $('#accountEditModal').modal('hide');
                    swalError("Some error occured!");
                    location.reload();
                }
                let data = {
                    category_id: $('#edit_category_id').val(),
                    amount: parseFloat( $('#edit_amount').val()),
                    location_id: $('#edit_location_id').val(),
                    acc_id: $('#acc_id').val(),
                    remarks: $('#edit_remarks').val(),
                    "_token": "{{ csrf_token() }}",
                };
                $.ajax({
                    type: 'put',
                    data: data,
                    url: BaseUrl + '/admin/accounting/update',
                    success: function(response) {
                        if (response.status == "fail") {
                            swalError(response.message);
                        } else {
                            swalSuccess(response.message);
                            $('#accountEditModal').modal('hide');
                        }
                        let table_id = 'accountings-table';
                        if (table_id && window.LaravelDataTables[table_id]) {
                            window.LaravelDataTables[table_id].draw();
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 403) {
                            swalError("403,Unauthorized access!");
                        } else if (xhr.status === 404) {
                            swalError("404,Not Found!");
                        } else {
                            swalError(xhr.responseText);
                        }

                    }
                });
            });
            $(document).on('click', '.btn-View', function(e) {
                $('.error_pop').hide();
                e.preventDefault();

                var trElement = $(this).closest('tr');

                let clicked = trElement.find('.item-class');
                $.ajax({
                    type: 'get',
                    url: BaseUrl + '/admin/accounting/' + clicked.data('id'),

                    success: function(response) {
                        $('#view-accounting-body').html(response.html);
                        $('#accountModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 403) {
                            swalError("403,Unauthorized access!");
                        } else if (xhr.status === 404) {
                            swalError("404,Not Found!");
                        } else {
                            swalError(xhr.responseText);
                        }

                    }
                });

            });

            $(document).on('click', '.btn-Edit', function(e) {
                $('.error_pop').hide();
                e.preventDefault();

                var trElement = $(this).closest('tr');

                let clicked = trElement.find('.item-class');
                $.ajax({
                    type: 'get',
                    url: BaseUrl + '/admin/accounting/' + clicked.data('id') + '/edit',
                    // data: {
                    //     "_token": "{{ csrf_token() }}",
                    // },
                    success: function(response) {
                        $('#edit-accounting-body').html(response.html);
                        $('#accountEditModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 403) {
                            swalError("403,Unauthorized access!");
                        } else if (xhr.status === 404) {
                            swalError("404,Not Found!");
                        } else {
                            swalError(xhr.responseText);
                        }

                    }
                });

            });

        });
    </script>
@endpush
