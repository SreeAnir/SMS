@once
    @push('modals')

     
        <div class="modal fade" id="change_status" tabindex="-1" aria-modal="true" role="dialog">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content rounded">
                    <!--begin::Modal header-->
                    <div class="modal-header pb-0 border-0 justify-content-end">
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                           <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                 transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                           <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                 fill="currentColor"></rect>
                       </svg>
                   </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--begin::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                        <!--begin:Form-->
                        <form id="kt_modal_new_target_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                              action="#">
                            <!--begin::Heading-->
                            <div class="mb-13 text-center">
                                <!--begin::Title-->
                                <h1 class="mb-3">@lang('Change status')</h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <div class="mb-7">
                                <select class="form-control status_input" name="status_id" id="status_id">
                                    <option value="">{{ __('Choose Status') }}</option>
                                    @foreach (App\Models\Status::list() as $option)
                                        <option value="{{ $option['id'] }}" data-attr="{{ $option['id'] }}"
                                            @if ($option['selected']) selected @endif>{{ $option['status'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-center">
                                <x-form.submit-button label="{{__('Update status')}}" discard="true"
                                                      id="update_status"
                                                      discard-execute="StatusManager.discard"/>
                            </div>
                            <!--end::Actions-->
                            <div></div>
                        </form>
                        <!--end:Form-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    @endpush
    <style>
    .indicator-progress{
        display: none;
    }
    </style>
    @push('scripts')
        <script>

            $(() => {
                 var statusUpdateRoute = "{{ route('status.update') }}";

                let StatusManager = {
                    element: null,
                    modal: null,
                    input: null,
                    submit: null,
                    model: null,
                    key: null,
                    current: null,

                    init: () => {
                        StatusManager.modal = $('#change_status');
                        StatusManager.input = StatusManager.modal.find('select.status_input');
                        StatusManager.submit = StatusManager.modal.find('#update_status');
                    },

                    setOptions: (current) => {
                        let statuses = StatusManager.element.data('statuses');
                        StatusManager.input.empty();
                        $.each(statuses, function (index, status) {
                            let option = new Option(status['status'], status['id']);
                            StatusManager.input.append(option);
                        })
                    },

                    showLoader: () => {
                        // Show loading indication
                        // StatusManager.submit.attr('data-kt-indicator', 'on');
                        console.log("shownig loader");
                        // Disable button to avoid multiple click
                        StatusManager.submit.prop('disabled', true);
                    },

                    hideLoader: () => {
                        // Hide loading indication
                        StatusManager.submit.removeAttr('data-kt-indicator');

                        // Enable button
                        StatusManager.submit.prop('disabled', false);
                    },

                    hideModal: () => {
                        StatusManager.modal.modal('hide');
                    },

                    setFrom: (element) => {
                        StatusManager.element = element;
                        StatusManager.model = element.data('model');
                        StatusManager.key = element.data('key');
                        StatusManager.current = element.data('current');
                        StatusManager.setOptions();
                        StatusManager.input.val(StatusManager.current.toString()).trigger('change');
                        StatusManager.modal.modal('show');
                    },

                    update: () => {
                        let value = StatusManager.input.val();
                        if (parseInt(StatusManager.current) === parseInt(value)) {
                            StatusManager.hideModal();
                            swalSuccess(__('Status updated successfully'));
                            return;
                        }
                        StatusManager.showLoader();
                        $.post(statusUpdateRoute, {
                            model: StatusManager.model,
                            key: StatusManager.key,
                            value
                        })
                            .then(response => {
                                StatusManager.hideModal();
                                if (response.status === 'success') {
                                    swalSuccess(response.message);
                                    status_text = response.status_text;
                                    StatusManager.relatedUpdates(value,status_text);
                                } else if (response.message) {
                                    swalError(response.message);
                                } else {
                                    swalError('Server error!');
                                }
                            })
                            .catch(e => {
                                response = e.responseJSON;
                                if (response.message) {
                                swalError(response.message);
                                }else{
                                swalError('Server error!');

                                }
                                StatusManager.hideModal();
                            })
                            .always(e => {
                                StatusManager.hideLoader();
                            });
                    },
                    relatedUpdates: (value, status_text ="" ) => {
                        StatusManager.current = value;
                        StatusManager.element.data('current', value);
                        if(status_text ==""){
                            status_text = (value == 1 ? __('Active') : __('Inactive') );
                        }
                        // .toggleClass('bg-success  bg-danger  bg-warning   bg-info').
                        class_name = 'bg-info'; 
                        if( value == 1 ){
                            class_name = 'bg-success'; 
                        }else if( value == 2 ){
                            class_name = 'bg-danger'; 
                        } 
                        else if( value == 3 ){
                            class_name = 'bg-warning'; 
                        }
                        $('.status-badge[data-model$="' + StatusManager.model.split('\\').pop() + '"][data-key="' + StatusManager.key + '"]').
                        removeClass('bg-success  bg-danger  bg-warning   bg-info').addClass(class_name)
                           .text(status_text);
                    },

                    discard: () => { 
                        StatusManager.hideModal();
                    }
                }

                window.StatusManager = StatusManager;
                StatusManager.init();
                $(document).on('click', '.change_status', e => {
                    e.preventDefault();
                    StatusManager.setFrom($(e.currentTarget));
                })
                StatusManager.submit.on('click', e => {
                    e.preventDefault();
                    StatusManager.update();
                })
            })
        </script>
    @endpush
@endonce
