<div class="form-floating fv-row component-date-time-picker">
    <input class="form-control form-control-solid " placeholder="{{$label}}" data-component-init="initDateTimePicker"
            {{$attributes->only(['name','id','value'])}}/>
    <label for="{{$attributes->get('id')}}" class="form-label">{{$label}}</label>

</div>
@once
    @push('scripts')
        <script>
            BladeComponents.initDateTimePicker = function (element) {
                element.daterangepicker({
                    singleDatePicker: true,
                    timePicker: true,
                    startDate: moment().startOf("hour"),
                    locale: {
                        format: "Y-M-DD hh:mm:ss"
                    }
                });
            }

            $(() => {
                $('.component-date-time-picker input').each((i, el) => {
                    BladeComponents.initDateTimePicker($(el));
                })
            });
        </script>
    @endpush
@endonce
