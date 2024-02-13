<div class="fv-row">
    <div class="input-group component-clock-picker flex-nowrap"
         data-component-init="initClockPicker" {{$attributes->except(['name','id'])}}>
        <div class="form-floating flex-grow-1">
            <input type="text" class="form-control {{$attributes->get('class','')}}"
                   {{$attributes->only(['name','value','disabled'])}}
                   placeholder="{{$label}}">
            <label>{{$label}}</label>
        </div>
        <span class="input-group-text">
            <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen013.svg-->
            <span class="svg-icon svg-icon-muted svg-icon-2x">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path opacity="0.3"
                      d="M20.9 12.9C20.3 12.9 19.9 12.5 19.9 11.9C19.9 11.3 20.3 10.9 20.9 10.9H21.8C21.3 6.2 17.6 2.4 12.9 2V2.9C12.9 3.5 12.5 3.9 11.9 3.9C11.3 3.9 10.9 3.5 10.9 2.9V2C6.19999 2.5 2.4 6.2 2 10.9H2.89999C3.49999 10.9 3.89999 11.3 3.89999 11.9C3.89999 12.5 3.49999 12.9 2.89999 12.9H2C2.5 17.6 6.19999 21.4 10.9 21.8V20.9C10.9 20.3 11.3 19.9 11.9 19.9C12.5 19.9 12.9 20.3 12.9 20.9V21.8C17.6 21.3 21.4 17.6 21.8 12.9H20.9Z"
                      fill="currentColor"/>
                <path d="M16.9 10.9H13.6C13.4 10.6 13.2 10.4 12.9 10.2V5.90002C12.9 5.30002 12.5 4.90002 11.9 4.90002C11.3 4.90002 10.9 5.30002 10.9 5.90002V10.2C10.6 10.4 10.4 10.6 10.2 10.9H9.89999C9.29999 10.9 8.89999 11.3 8.89999 11.9C8.89999 12.5 9.29999 12.9 9.89999 12.9H10.2C10.4 13.2 10.6 13.4 10.9 13.6V13.9C10.9 14.5 11.3 14.9 11.9 14.9C12.5 14.9 12.9 14.5 12.9 13.9V13.6C13.2 13.4 13.4 13.2 13.6 12.9H16.9C17.5 12.9 17.9 12.5 17.9 11.9C17.9 11.3 17.5 10.9 16.9 10.9Z"
                      fill="currentColor"/>
                </svg>
            </span>
            <!--end::Svg Icon-->
        </span>
    </div>
</div>
@once
    @push('styles')
        <link rel="stylesheet" href="{{asset('assets/plugins/custom/clockpicker/dist/jquery-clockpicker.min.css')}}"/>
        <style>
            .component-clock-picker label {
                z-index: 100;
            }

            .component-clock-picker.form-floating > .form-control:focus ~ label,
            .component-clock-picker.form-floating > .form-control:not(:placeholder-shown) ~ label,
            .component-clock-picker.form-floating > .form-select ~ label {
                transform: scale(0.85) translateY(calc(-0.5rem + -5px)) translateX(0.15rem);
            }

            .popover {
                z-index: 215000000 !important;
            }

        </style>
    @endpush
    @push('scripts')
        <script src="{{asset('assets/plugins/custom/clockpicker/dist/jquery-clockpicker.min.js')}}"></script>
        <script>
            BladeComponents.initClockPicker = function (element) {
                element.clockpicker({
                    autoclose: true,
                    donetext: '@lang('Done')',
                    afterDone: function () {
                        element.find('input').change();
                    }
                });
            }

            $(() => {
                $('.component-clock-picker').each((i, el) => {
                    BladeComponents.initClockPicker($(el));
                })
            });
        </script>
    @endpush
@endonce
