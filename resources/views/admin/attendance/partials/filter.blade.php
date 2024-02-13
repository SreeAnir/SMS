@php
    use Carbon\Carbon;
    $now = Carbon::now();
    $year_from = 2023;
    $curr_yr =  $now->format('Y');
    $curr_month =  $now->format('m');
    $yearsArray = [];

    for ($year = $year_from; $year <= $curr_yr; $year++) {
        $yearsArray[] = $year;
    }
    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

@endphp

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
                        <option value="{{ $year}}" data-attr="{{ $year }}"  
                        {{ ( $curr_yr == $year ? "selected='selected' ":"" ) }}>{{ $year }}
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
                        <option  {{ ( ($key +1) == ($curr_month) ? "selected='selected' ":"" ) }} value="{{ $key + 1 }}" data-attr="{{ $month }}">{{ $month }}
                        </option>
                    @endforeach
                </select>
                <div id="passwordHelpBlock" class="form-text">
                    View Attendance by month
                </div>
            </div>
        </div>
         
         

        <div class="col-md-4">
                <label for="Paymentstatus" class="form-label">Choose Student</label>
                <x-form.select2 label="" text_key="full_name" name="student_id"  id="student_id"  valueKey="rfid"
                    :options="$users" placeholder="{{ __('   -Choose Student- ') }}">
                </x-form.select2>
        </div>


        @php
            // $filter = [];
            // if (auth()->user()->location_id != null) {
            //     $filter['location_id'] = auth()->user()->location_id;
            // }
            // $location_list = locationList($filter);

        @endphp
        {{-- <div class="col-md-2">
            <div class="fv-row">

                <label for="inputPassword5" class="form-label">Choose Location</label>

                <select class="form-control" name="location_id" id="location_id">
                    <option value="">{{ __('Choose Location') }}</option>
                    @foreach ($location_list as $key => $location)
                        <option value="{{ $location->id }}" data-attr="{{ $location->id }}">{{ $location->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div> --}}


    </div>
</form>

@push('styles')
<style>
#attendance-table_filter{
    display: none;
}
</style>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            $(document).on('change', '#year', function(e) {
               $("#month option:first").prop("selected", true);
            });
             
        });
    </script>
@endpush
