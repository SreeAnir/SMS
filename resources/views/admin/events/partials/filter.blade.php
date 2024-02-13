@php
    use Carbon\Carbon;
    $months = [
    'January', 'February', 'March', 'April',
    'May', 'June', 'July', 'August',
    'September', 'October', 'November', 'December'
];

     
@endphp
<form method="post" action="#" id="payment_filter_form">
    @csrf
    <div class="row mt-3">
            <div class="col-md-2">
                <div class="fv-row">
                    <select class="form-control" name="month" id="month">
                        <option value="">{{ __('Choose Month') }}</option>
                        @foreach ($months as $key => $month)
                            <li>{{ $month }}</li>
                            <option value="{{ $key+1 }}" data-attr="{{ $month }}">{{ $month }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
             
            <div class="col-md-2">
                <div class="fv-row d-flex flex-row">
                    <span class="mx-2"> OR  </span>
                    <input autocomplete="off" placeholder="{{ __('Event date') }}" type="text"  class="form-control" id="created_at" name="created_at" >
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