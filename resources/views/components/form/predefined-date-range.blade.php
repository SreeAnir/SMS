<div class="form-floating fv-row component-predefined-date-time-picker">
    <input type="search" class="form-control form-control-solid predefined-date-time-picker" placeholder="{{$label}}"  {{$attributes->only(['name','id','value'])}} />
    <label for="{{$attributes->get('id')}}"  class="form-label">{{$label}}</label>
</div>
@once
    @push('scripts')
        <script>
            $(function() {
                $('.predefined-date-time-picker').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: '{{ __('clear') }}',
                        applyLabel: '{{ __('apply') }}'
                    },
                    ranges: {
                        "Today": [moment(), moment()],
                        "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                        "Last 7 Days": [moment().subtract(6, "days"), moment()],
                        "Last 30 Days": [moment().subtract(29, "days"), moment()],
                        "This Month": [moment().startOf("month"), moment().endOf("month")],
                        "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                    },
                    clearBtn: true,
                });
                $('.predefined-date-time-picker').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY')).trigger('change');
                });

                $('.predefined-date-time-picker').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('').trigger('change');
                });

                //$('.predefined-date-time-picker').clearSearch();
            });
        </script>
    @endpush
@endonce
