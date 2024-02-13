<div class="form-floating fv-row component-date-picker" {{$attributes->except(['name','id','value'])}}>
    <input class="form-control" placeholder="{{$label}}"
           {{$attributes->only(['name','id','value'])}} data-component-init="initDatePicker"/>
    <label for="{{$getId()}}" class="fs-6 fw-bold form-label mb-2">{{$label}}</label>
</div>
@once
    @push('scripts')
        <script>

            BladeComponents.initDatePicker = function (element) {
                let config = {
                    dateFormat: 'Y-m-d',
                    minDate: "{{$attributes->get('min','today')}}",
                }
                let el_config = element.parent().attr('config');
                if (el_config) {
                    el_config = JSON.parse(el_config);
                    config = {...config, ...el_config};
                }
                element.flatpickr(config);
            }

            $(() => {
                $('.component-date-picker input').each((i, el) => {
                    BladeComponents.initDatePicker($(el));
                })
            });

        </script>
    @endpush
@endonce
