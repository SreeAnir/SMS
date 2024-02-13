@if($discard)
    <button type="reset" {{ $attributes->whereStartsWith('discard-') }}
    class="btn btn-lg btn-light-primary fw-bolder me-2 submit-discard {{$attributes->get('discard-class')}}">
        {{$attributes->get('discard-label')??__('Discard')}}
    </button>
@endif
<!--begin::Submit button-->
<button {{$attributes->whereDoesntStartWith('discard-')->merge(['type'=>'submit'])->except('class')}} class="btn btn-primary form-submit {{$attributes->get('class')}}">
    <span class="indicator-label">{{$label}}</span>
    <span class="indicator-progress">
        {{$attributes->get('loading-label') ?? __('Please wait...')}}
        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
    </span>
</button>
<!--end::Submit button-->

@once
    @push('scripts')
        <!-- Script added from view/components/form/submit-button component -->
        <script>
            $(document).on("click",".form-submit",function(e) {

            // $('.form-submit').click(e => { alert();
                e.preventDefault();
                let el = $(e.currentTarget);
                let execute = el.attr('submit-execute');
                if (execute) {
                    execute = eval(execute);
                    if (typeof execute === 'function') {
                        execute();
                    } else {
                        console.error('The attribute submit-execute on submit-button attribute should be a function!');
                    }
                }
            })
            // $('.submit-discard').click(e => { alert("dk");
            $(document).on("click",".submit-discard",function(e) {

                let el = $(e.currentTarget);
                swalConfirm(el.attr('discard-message'), el.attr('discard-title') ?? '{{__('Are you sure?')}}', {
                    confirmButtonText: el.attr('discard-confirm-label') ?? '{{__('Yes')}}',
                    cancelButtonText: el.attr('discard-cancel-label') ?? '{{__('No')}}',
                }).then(result => {
                    if (result.isConfirmed) {
                        let redirect = el.attr('discard-redirect');
                        if (redirect) {
                            window.location.href = redirect;
                            return;
                        }

                        let execute = el.attr('discard-execute');
                        if (execute) {
                            execute = eval(execute);
                            if (typeof execute === 'function') {
                                execute();
                            } else {
                                console.error('The attribute discard-execute on submit-button attribute should be a function!');
                            }
                        }
                    }
                })
            });
        </script>
    @endpush
@endonce