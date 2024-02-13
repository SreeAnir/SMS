<div class="fv-row component-int-tel-container">
    <input type="text" {{$attributes->except(['class'])}} data-component-init="initIntTel" placeholder="{{$label}}"
           class="form-control form-control-solid fw-bold fs-6 component-int-tel {{$attributes->get('class')}}"/>
    <label class="fs-6 fw-bold form-label mb-2" for="{{$getId()}}">{{$label}}</label>
    <input type="hidden" name="full_{{$getName()}}" value="{{$attributes->get('value')}}">
</div>
@once
    @push('styles')
        <link rel="stylesheet" href="{{asset('assets/plugins/custom/intl-tel-input/build/css/intlTelInput.css')}}"/>
        <style>
            .iti {
                display: block;
            }
        </style>
    @endpush
@endonce
@push('scripts')
    @once
        <script src="{{asset('assets/plugins/custom/intl-tel-input/build/js/intlTelInput.js')}}"></script>
        <script>
            BladeComponents.initIntTel = function (element) {
                let config = {
                    utilsScript: "{{asset('assets/plugins/custom/intl-tel-input/build/js/utils.js')}}",
                    formatOnDisplay: false,
                    separateDialCode: true,
                    preferredCountries: ['qa', 'ae', 'sa', 'bh', 'kw', 'om'],
                    excludeCountries: ["il"],
                    initialCountry: "auto",
                    customContainer: "form-floating",
                    geoIpLookup: function (success, failure) {
                        $.get("https://ipinfo.io", function () {
                        }, "jsonp").always(function (resp) {
                            var countryCode = (resp && resp.country) ? resp.country : "qa";
                            success(countryCode);
                        })
                    },
                };
                let el_config = element.attr('config');
                if (el_config) {
                    el_config = JSON.parse(el_config);
                    if (el_config['onlyCountries']) {
                        delete config['preferredCountries'];
                        config['initialCountry'] = el_config['onlyCountries'][0];
                    }
                    config = {...config, ...el_config};
                    console.log('Int-tel-input config -> ', config);
                }
                let iti = window.intlTelInput(element[0], config);
                element.data('iti', iti);

                let labelInitialized = false;
                let correctLabel = function () {
                    let container = element.closest('.component-int-tel-container');
                    let label = container.find('label');
                    if (!labelInitialized) {
                        label.appendTo(element.closest('.form-floating'));
                        labelInitialized = true;
                    }
                    let width = container.find('.iti__flag-container').width();
                    label.css('left', (width - 5) + 'px');
                }
                element.on("countrychange", function () {
                    correctLabel();
                });
                correctLabel();

                element.on('countrychange change keyup', function () {
                    $('input[name="full_' + element.attr('name') + '"]').val(iti.getNumber());

                    //Revalidate field if validator exists
                    let validationHelper = FormValidationHelper.getInstanceFromElement(element);
                    if (validationHelper) {
                        validationHelper.safelyReValidateField(element.attr('name'), true);
                    }
                });
            }

            $(() => {
                $('.component-int-tel:visible').each((i, el) => {
                    BladeComponents.initIntTel($(el));
                })

                let observer = new MutationObserver(mutations => {
                    $('.component-int-tel:visible:not([data-intl-tel-input-id])').each((i, el) => {
                        BladeComponents.initIntTel($(el));
                    })
                });
                observer.observe(document.getElementById('kt_content'), {
                    attributes: true,
                    subtree: true,
                });
            })
        </script>
    @endonce
@endpush
