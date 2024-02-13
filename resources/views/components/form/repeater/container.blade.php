<!--begin::Repeater-->
<div id="{{$getId()}}" data-name="{{$getName()}}" class="repeater-component-container">
    <!--begin::Form group-->
    <div class="form-group">
        <div data-repeater-list="{{$getName()}}">
            {{$slot}}
        </div>
    </div>
    <!--end::Form group-->

    <!--begin::Form group-->
    <div class="form-group mt-5">
        <a href="javascript:void(0)" data-repeater-create class="btn btn-primary">
            <em class="la la-plus"></em> @lang('Add')
        </a>
    </div>
    <!--end::Form group-->
</div>
<!--end::Repeater-->
@push('scripts')
    @once
        <script src="{{asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js')}}"></script>
    @endonce
    <script>
        $(() => {
            let default_config = {
                initEmpty: false,
                defaultValues: {},
            };
            //Config options
            let config = JSON.parse('{!! html_entity_decode($attributes->get('config','{}')) !!}');
            let element = $('#{{$getId()}}');

            element.repeater($.extend(default_config, config, {
                show: function () {
                    @if($attributes->has('show-execute'))
                    let showExecute = eval({{$attributes->get('show-execute')}});
                    if (typeof showExecute === 'function') {
                        $.proxy(showExecute, this)();
                    }
                    @endif

                    //Initialize components scripts
                    $(this).find('[data-component-init]').each((i, el) => {
                        let closure = eval('BladeComponents.' + $(el).attr('data-component-init'));
                        if (typeof closure === 'function') {
                            closure($(el));
                        }
                    })

                    //Process field validations
                    let helper = FormValidationHelper.getInstanceFromElement(this);
                    if (helper) {
                        helper.processRepeaters($(this), element);
                    }
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    @if($attributes->has('hide-execute'))
                    let hideExecute = eval({{$attributes->get('hide-execute')}});
                    if (typeof hideExecute === 'function') {
                        $.proxy(hideExecute, this)();
                    }
                    @endif

                    //Process field validations
                    let helper = FormValidationHelper.getInstanceFromElement(this);
                    if (helper) {
                        helper.removeRepeaters($(this));
                        let list = $(this).closest('[data-repeater-list]');
                        $(this).slideUp(() => {
                            deleteElement();
                            helper.processRepeaters(list, element);
                        });
                    } else {
                        $(this).slideUp(deleteElement);
                    }
                },
                @if($attributes->has('isFirstItemUndeletable'))
                isFirstItemUndeletable: true,
                @endif
            }));

            // =========== After repeater is initialized =========== */
            @if($attributes->has('init-execute'))
            let initExecute = eval({{$attributes->get('init-execute')}});
            if (typeof initExecute === 'function') {
                initExecute();
                $.proxy(initExecute, this)();
            }
            @endif

            //Initialize components scripts
            element.find('[data-component-init]').each((i, el) => {
                let closure = eval('BladeComponents.' + $(el).attr('data-component-init'));
                if (typeof closure === 'function') {
                    closure($(el));
                }
            })
            /** =========== After repeater is initialized =========== */
        })
    </script>
@endpush
