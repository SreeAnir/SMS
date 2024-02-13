@php
    use Carbon\Carbon;
    $now = Carbon::now();
    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

@endphp
<form method="post" action="#" id="payment_filter_form">
    @csrf
    <div class="row mt-3">
        <div class="col-md-2">
            <div class="fv-row">
                <label for="Paymentstatus" class="form-label">Paid Month(Yr {{ $now->year }})</label>
                <select class="form-control" name="month" id="month">
                    <option value="">{{ __('Choose Month') }}</option>
                    @foreach ($months as $key => $month)
                        <li>{{ $month }}</li>
                        <option value="{{ $key + 1 }}" data-attr="{{ $month }}">{{ $month }}
                        </option>
                    @endforeach
                </select>
                <div id="passwordHelpBlock" class="form-text">
                    View payments by month
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="fv-row">
                <label for="Paymentstatus" class="form-label">Paid Date</label>
                <input autocomplete="off" placeholder="{{ __('Paid date') }}" type="text"  class="form-control" id="created_at" name="created_at" >
                <div id="passwordHelpBlock" class="form-text">
                  Or View payments by Date
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="fv-row">
                <label for="Paymentstatus" class="form-label">Staff ID </label>
                <select class="form-control" name="staff_id" id="staff_id">
                    <option value="">{{ __('Choose Student') }}</option>
                    @foreach ($users as $key => $staff)
                        <option value="{{ $staff->id }}" data-attr="{{ $staff->full_name }}">
                           {{ $staff->full_name }}(  {{ $staff->ID_Number }} )
                        </option>
                    @endforeach
                </select>
            </div>
        </div>


        @php
            $filter = [];
            if (auth()->user()->location_id != null) {
                $filter['location_id'] = auth()->user()->location_id;
            }
            $location_list = locationList($filter);

        @endphp
        <div class="col-md-2">
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
        </div>


    </div>
</form>

@push('styles')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            $('#created_at').datepicker({
                format: 'yyyy-mm-dd', // You can adjust the format as needed
                autoclose: true,
                endDate: 'today', // Prevent selecting future dates
            });

        });
    </script>
@endpush
