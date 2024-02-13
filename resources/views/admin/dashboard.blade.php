@extends('layouts.admin.app')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp

    <div class="row">
        <div class="col-md-12">
            <div class="card  shadow-sm bg-white rounded">
                <div class="card-body d-flex flex-row  justify-content-between">
                    <h3>
                        {{ env('APP_NAME') }} Dashboard
                    </h3>
                    <div class="float-right font-weight-light text-muted">
                        Last refreshed at <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                            <path
                                d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483m.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535m-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z" />
                            <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                            <path
                                d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                        </svg>
                        <span class=" text-secondary">{{ Carbon::now() }}</span>
                    </div>


                </div>
            </div>
        </div>
    </div>
    @include('admin.dashboard.event-card')

    <div class="row mx-1">
        @include('admin.dashboard.sales-cards')

        <div class="col-md-2">
            <div class="card  bg-light  shadow-sm bg-white rounded">
                <div style="height: 200px"
                    class="card-body text-center  bg-white  d-flex flex-column p-1   justify-content-around">
                    <div class="border-bottom pb-1">
                        <h1 class="text-center"> <a href="{{ route('students.index') }}" class="sidebar-link"><i
                                    class="text-danger fas fa-users"></i><span class="hide-menu">
                                </span></a></h1>
                        <h3 class="mb-0 fw-bold">{{ $new_application_count }}</h3>
                        <span class="text-muted"><a href="{{ route('students.index') }}">New Applications</a></span>
                    </div>
                    <div>
                        <h1 class="text-center"> <a href="{{ route('students.index') }}" class="sidebar-link"><i
                                    class="text-muted fas fa-users"></i><span class="hide-menu">
                                </span></a></h1>
                        <h3 class="mb-0 fw-bold">{{ $students_count }}</h3>
                        <span class="text-muted"><a href="{{ route('students.index') }}">Students</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm  bg-white rounded">
                <div class="card-body  bg-white cls-pie" style="height: 200px">
                    <h5 class="card-title">Income Summary for {{ @$month }} ({{ @$month_income }}) </h5>
                    <div id="monthly_income" style="height: 150px"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card  shadow-sm bg-white rounded">
                <div class="card-body  bg-white cls-pie" style="height: 200px">
                    <h5 class="card-title">Expense Summary for {{ @$month }} ({{ @$month_expense }})</h5>
                    <div id="monthly_expense" style="height: 150px"></div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card  shadow-sm bg-white rounded">
                <div style="height: 200px"
                    class="card-body text-center  bg-white  d-flex flex-column p-1   justify-content-around">
                    <div class="border-bottom">
                        <label class="text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-node-minus-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M16 8a5 5 0 0 1-9.975.5H4A1.5 1.5 0 0 1 2.5 10h-1A1.5 1.5 0 0 1 0 8.5v-1A1.5 1.5 0 0 1 1.5 6h1A1.5 1.5 0 0 1 4 7.5h2.025A5 5 0 0 1 16 8m-2 0a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h5A.5.5 0 0 0 14 8" />
                            </svg> Net Income {{ @$total_income }}</label>
                        <label class="text-danger"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-node-plus-fill" viewBox="0 0 16 16">
                                <path
                                    d="M11 13a5 5 0 1 0-4.975-5.5H4A1.5 1.5 0 0 0 2.5 6h-1A1.5 1.5 0 0 0 0 7.5v1A1.5 1.5 0 0 0 1.5 10h1A1.5 1.5 0 0 0 4 8.5h2.025A5 5 0 0 0 11 13m.5-7.5v2h2a.5.5 0 0 1 0 1h-2v2a.5.5 0 0 1-1 0v-2h-2a.5.5 0 0 1 0-1h2v-2a.5.5 0 0 1 1 0" />
                            </svg> Net Expense {{ @$total_expense }}</label>

                    </div>
                    <div class="border-bottom">
                        <h1 class="text-center"> <a href="{{ route('students.index') }}">
                                @if ($net_revenue < 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red"
                                        class="bi bi-graph-down-arrow" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M0 0h1v15h15v1H0zm10 11.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-1 0v2.6l-3.613-4.417a.5.5 0 0 0-.74-.037L7.06 8.233 3.404 3.206a.5.5 0 0 0-.808.588l4 5.5a.5.5 0 0 0 .758.06l2.609-2.61L13.445 11H10.5a.5.5 0 0 0-.5.5" />
                                    </svg>
                        </h1>
                        <h3 class="mb-0 fw-bold text-danger">{{ @$net_revenue }}</h3>
                        @endif
                        @if ($net_revenue >= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green"
                                class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5" />
                            </svg>

                            </h1>
                            <h3 class="mb-0 fw-bold text-success">{{ @$net_revenue }}</h3>
                        @endif



                        <span class="text-muted">Net Revenue</span>

                    </div>
                    <h6 class="mb-0  text-info"><a href="{{ route('accounting.index') }}"> View Accounting</a></h6>
                    <h6 class="mb-0   text-info"><a href="{{ route('accounting-categories.index') }}"> View Categories</a>
                    </h6>


                </div>
            </div>
        </div>
    </div>

    <!-- Chart-3 -->
    <div class="row">
        @php
            $title = 'Top 5 Income by Category';
            $listing = @$top_five_income;
        @endphp
        @include('admin.dashboard.list')

        @php
            $title = 'Top 5 Expenses by Category';
            $listing = @$top_five_expense;
        @endphp
        @include('admin.dashboard.list')


    </div>
    </div>

    <!-- End chart-3 -->
    <!-- Charts -->

    @push('scripts')
        <script src="{{ asset('/assets/libs/flot/jquery.flot.js') }}"></script>
        <script src="{{ asset('/assets/libs/flot/jquery.flot.time.js') }}"></script>
        <script src="{{ asset('/assets/libs/flot/jquery.flot.pie.js') }}"></script>

        <script src="{{ asset('/assets/libs/flot/jquery.flot.stack.js') }}"></script>
        <script src="{{ asset('/assets/libs/flot/jquery.flot.crosshair.js') }}"></script>
        <script src="{{ asset('/assets/libs/chart/jquery.peity.min.js') }}"></script>
        <script src="{{ asset('/assets/libs/chart/matrix.charts.js') }}"></script>
        {{-- <script src="{{ asset('/assets/libs/chart/jquery.flot.pie.min.js') }}"></script> --}}
        <script src="{{ asset('/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>

        <script>
            var data_income = @json(@$monthly_income_data);
            console.log(data_income);
            if (data_income != null && data_income.length > 0) {
                $('#monthly_income').css({
                    'width': '90%',
                    'min-height': '150px'
                });
                var my_chart2 = $.plot('#monthly_income', data_income, {
                    series: {
                        pie: {
                            show: true,
                            innerRadius: 0.5,
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
                $('#monthly_income').html("No Income Added");
            }


            var data_expense = @json(@$monthly_expense_data);
            console.log(data_expense);
            if (data_expense != null && data_expense.length > 0) {
                $('#monthly_expense').css({
                    'width': '90%',
                    'min-height': '150px'
                });
                var my_chart2 = $.plot('#monthly_expense', data_expense, {
                    series: {
                        pie: {
                            show: true,
                            innerRadius: 0.5,
                            highlight: {
                                opacity: 0.20
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
                $('#monthly_expense').html("No Income Added");
            }
        </script>
    @endpush
@endsection
