<div class="form-floating fv-row component-date-range-picker">
    <input class="form-control form-control-solid" placeholder="{{$label}}"  data-component-init="initDateRangePicker"
            {{$attributes->only(['name','id','value'])}}/>
    <label for="{{$attributes->get('id')}}" class="form-label">{{$label}}</label>
</div>

@once
    @push('scripts')
        <script>
            BladeComponents.initDateRangePicker = function (element) {
                element.daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        format: "Y-M-DD",
                        cancelLabel: 'Clear'
                    }

                });
                element.on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('Y-M-DD') + ' - ' + picker.endDate.format('Y-M-DD')).change();
                });

                element.on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('').change();
                    picker.setStartDate({});
                    picker.setEndDate({});
                });
            }

            $(() => {
                $('.component-date-range-picker input').each((i, el) => {
                    BladeComponents.initDateRangePicker($(el));
                })
            });
        </script>
    @endpush
@endonce
