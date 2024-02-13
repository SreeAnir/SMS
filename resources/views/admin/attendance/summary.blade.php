@php
    use Carbon\Carbon;
    $now = Carbon::now();
    $year_from = 2023;
    $curr_yr = $now->format('Y');
    $curr_month = $now->format('m');
    $yearsArray = [];
    $filter = [];
    if (auth()->user()->location_id != null) {
        $filter['location_id'] = auth()->user()->location_id;
    }
    $location_list = locationList($filter);

    for ($year = $year_from; $year <= $curr_yr; $year++) {
        $yearsArray[] = $year;
    }
    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

@endphp
<div class="card">
    <h5 class="card-header">Monthly Attendance Sheet</h5>
    <div class="card-body">
        <form method="post" action="#" id="attendance_filter_form">
            @csrf
            <div class="row mt-3">

                <div class="col-md-2">
                    <div class="fv-row">
                        <label for="Paymentstatus" class="form-label">(Year)</label>
                        <select class="form-control" name="year" id="year">
                            <option value="">{{ __('Choose Year') }}</option>
                            @foreach ($yearsArray as $key => $year)
                                <li>{{ $year }}</li>
                                <option value="{{ $year }}" data-attr="{{ $year }}"
                                    {{ $curr_yr == $year ? "selected='selected' " : '' }}>{{ $year }}
                                </option>
                            @endforeach
                        </select>
                        <div id="passwordHelpBlock" class="form-text">
                            Choose year then month
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="fv-row">
                        <label for="Paymentstatus" class="form-label">(Month)</label>
                        <select class="form-control" name="month" id="month">
                            <option value="">{{ __('Choose Month') }}</option>
                            @foreach ($months as $key => $month)
                                <li>{{ $month }}</li>
                                <option {{ $key + 1 == $curr_month ? "selected='selected' " : '' }}
                                    value="{{ $key + 1 }}" data-attr="{{ $month }}">{{ $month }}
                                </option>
                            @endforeach
                        </select>
                        <div id="passwordHelpBlock" class="form-text">
                            View Attendance by month
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="fv-row">
                        <label for="inputPassword5" class="form-label">Choose Location</label>

                        <select class="form-control" name="location_id" id="location_id">
                            <option value="">{{ __('Choose Location') }}</option>
                            @foreach ($location_list as $key => $location)
                                <option value="{{ $location->id }}" data-attr="{{ $location->id }}">
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
               
                @if(@$user_type == "staff" )
                
                @else 

                <div class="col-md-3">
                    <div class="fv-row">

                        <label for="inputPassword5" class="form-label">Choose Batch</label>

                        <select class="form-control" name="batch_id" id="batch_id">
                            <option value="">{{ __('Choose batch') }}</option>
                            @foreach (batchList() as $option)
                                <option value="{{ $option->id }}" data-attr="{{ $option->id }}"
                                    data-location="{{ $option->location_id }}"
                                    @if ($option['selected']) selected @endif>
                                    {{ $option->batch_name }}({{ $option->location->name }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="Paymentstatus" class="form-label">Choose Student</label>
                    <x-form.select2 label="" text_key="full_name" name="user_id" id="user_id" valueKey="rfid"
                        :options="$users" placeholder="{{ __('   -Choose Student- ') }}">
                    </x-form.select2>
                </div>
                @endif
            
                <div class="col-md-1">
                    <div class="fv-row">

                        <label for="inputPassword5" class="form-label"> &nbsp;</label>

                        <input class="form-control btn btn-info text-white" type="button" id="filter_btn"
                            value="Filter">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="fv-row">

                        <label for="inputPassword5" class="form-label"> &nbsp;</label>

                        <input class="form-control btn btn-secondary text-white" type="reset" id="reset_form"
                            value="Reset">
                    </div>
                </div>

            </div>
        </form>

        <div class="col-12 mt-3 border-top" id='paper-view'>
        @include('admin.attendance.paper-view')
        </div>

    </div>

</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            
            $(document).on('click', '#reset_form', function(e) {
                 $('#filter_btn').trigger('click');
            });
            $(document).on('change', '#year', function(e) {
                $("#month option:eq(1)").prop("selected", true);
            });

            $(document).on('change', '#location_id', function(e) {
                changeLocation();
            });
            $(document).on('click', '#filter_btn', function() {
                filterRecords();
            });
        });

        function changeLocation() {
            var selectedLocation = $('#location_id').val();
            $('#batch_id').val('');
            $('#batch_id option').hide();
            $('#batch_id option[data-location="' + selectedLocation + '"]').show();
        }

        function filterRecords() {
            var formData = $('#attendance_filter_form').serialize();
            $.ajax({
                type: 'get',
                url: "{{ $route}}",
                data:formData  ,
                success: function(response) {
                    if(response.status =="success"){
                        $('#paper-view').html(response.html);
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
        }
    </script>
@endpush
