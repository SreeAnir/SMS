@php
    use Carbon\Carbon;
    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

@endphp
<form method="post" action="#" id="payment_filter_form" class="filter_search_form">
    @csrf
    <div class="row mt-3">
        <div class="col-md-2">
            <div class="fv-row">
                <select class="form-control" id="choose_types">
                    <option value="">{{ __('Choose Duration Type') }}</option>
                    <option value="1">By Month
                    </option>
                    <option value="2">By Date
                    </option>
                    <option value="3">By Date Range
                    </option>
                </select>
            </div>
        </div>
        <div class="col-md-2 choose_types_options option_1">
            <div class="fv-row">
                <select class="form-control  " name="month" id="month">
                    <option value="">{{ __('Choose Month') }}</option>
                    @foreach ($months as $key => $month)
                        <option value="{{ $key + 1 }}" data-attr="{{ $month }}">{{ $month }}
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2  option_2  choose_types_options">
            <div class="fv-row">
                <input autocomplete="off" placeholder="{{ __('Date') }}" type="text" class="form-control"
                    id="date" name="date">
            </div>
        </div>
        <div class="col-md-3 col-sm-4 option_3 choose_types_options">
            <div class="fv-row d-flex flex-row justify-content-between">
                <div class="flex-item"> <!-- Add mb-2 for margin-bottom -->
                    <input autocomplete="off" placeholder="{{ __('From Date') }}" type="text" class="form-control"
                        id="date_from" name="date_from">
                </div>
                <div class="flex-item">
                    <input autocomplete="off" placeholder="{{ __('To Date') }}" type="text" class="form-control"
                        id="date_to" name="date_to">
                </div>
            </div>
        </div>


        <div class="col-md-2">
            <div class="fv-row">
                <select class="form-control " name="category_id" id="category_id">
                    <option value="">{{ __('Choose By Category') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_label }}
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            @if (auth()->user()->location_id == '')
                @php
                    $locationList = locationList();
                @endphp
                <select class="form-control" id="location_id" name="location_id" required>
                    <option value="">Select Location</option>
                    @if (!empty($locationList))
                        @foreach ($locationList as $ll)
                            <option value="{{ $ll->id }}" {{ @$accounting->location_id }}
                                {{ isset($accounting) && $accounting->location_id == $ll->id ? 'selected' : '' }}>
                                {{ $ll->name }}</option>
                        @endforeach
                    @endif
                </select>
             @else 
             <input type="hidden"  value="{{ auth()->user()->location_id }}" id="location_id" name="location_id" />
            @endif
        </div>
    </div>
</form>

@push('styles')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
        .dataTables_filter {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            $('.choose_types_options').hide();
            $('#choose_types').change(function(e) {
                var selectedValue = $(this).val();
                console.log(selectedValue);

                $('.choose_types_options').hide();
                $('.choose_types_options input').val('');
                $('.choose_types_options select').val('');
                $('.option_' + selectedValue).show();
            });


            $("#date").datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd', // You can adjust the format as needed
                endDate: 'today',
                onSelect: function(date) {

                    // Add your callback logic here
                }
            });

            $("#date_from").datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd', // You can adjust the format as needed
                endDate: 'today',
                onSelect: function(date) {
                    console.log(date);
                    $('#date_to').datepicker('setStartDate', date);
                    // Add your callback logic here
                }
            });
            $('#date_to').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd', // You can adjust the format as needed
                endDate: 'today',

            });

        });
    </script>
@endpush
