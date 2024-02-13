@php
    use Carbon\Carbon;
    $now = Carbon::now();
    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

@endphp
<form method="post" action="#" id="payment_filter_form"  class="filter_search_form">
    @csrf
    <div class="row mt-3">
        <div class="col-md-4">
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

        <div class="col-md-4">
            <div class="fv-row">
                <label for="Paymentstatus" class="form-label">Payment status</label>
                <select class="form-control" name="paymet_status" id="paymet_status">
                    <option value="">{{ __('Choose paymet status') }}</option>
                    @foreach ($paymet_statuses as $status)
                        <li>{{ $month }}</li>
                        <option value="{{ $status->id }}" data-attr="{{ $status->status }}">{{ $status->status }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="col-md-4">
            <div class="fv-row">
                <label for="Paymentstatus" class="form-label">Student ID </label>
                <select class="form-control" name="student" id="student">
                    <option value="">{{ __('Choose Student') }}</option>
                    @foreach ($users as $key => $student)
                        <option value="{{ $student->ID_Number }}" data-attr="{{ $student->full_name }}">
                            {{ $student->ID_Number }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="fv-row">
                <label for="Paymentstatus" class="form-label">Fee Type</label>
                <select class="form-select" placeholder="{{ __('Fee Type') }}" id="fee_type" name="fee_type">
                    <option value="">Choose Fee Type</option>
                    @foreach (feeTypelist() as $type => $key)
                        <option value="{{ $type }}">({{ $key }})</option>
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
        <div class="col-md-4">
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

        <div class="col-md-3">
            <div class="fv-row">

                <label for="inputPassword5" class="form-label">Choose Batch</label>

                <select class="form-control" name="batch" id="batch">
                    <option value="">{{ __('Choose Batch') }}</option>
                    @foreach ($batches as $key => $batch)
                        <option value="{{ $batch->id }}" data-attr="{{ $batch->id }}">{{ $batch->batch_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-1">
            <div class="fv-row">
                <label for="inputPassword5" class="form-label">&nbsp;</label>
                <div class="fv-row">
                    <input  type="reset" class="btn btn-secondary " id="reset" value="Reset" />
                </div>
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
