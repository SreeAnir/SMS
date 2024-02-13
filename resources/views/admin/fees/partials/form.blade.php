@php
    use App\Models\Fee;
    $student_id = request('student_id');
@endphp
<div class="card mb-2 mb-xxl-8 box-card">
    <form class="form-horizontal" method="POST" id="manage-fee">
        @csrf
        <div class="card-body pt-9 pb-0">
            <h6 class="tet-muted">Student Fee Info <input id="deleted" type="button" class="btn btn-danger"
                    value="Deleted"></h6>
            <div class="row">
                <div class="col-md-4">
                    <label for="Paymentstatus" class="form-label">Choose Student</label>
                    <x-form.select2 label="" text_key="full_name" name="student_list" value="2" id="student_list" valueKey="id"
                    value="{{ @$student_id  }}"
                        :options="$users" placeholder="{{ __('   -Choose Student- ') }}">
                    </x-form.select2>
                    <input id="fee_id" name="fee_id" type="hidden" readonly />
                </div>
                @php 
            //  $user = $users[0];
                @endphp
                {{-- <div class="col-md-8 col-sm-12">
                    <div class="form-group">
                        <label for="last_name">@lang('Choose Student')</label>

                        
                        <select class="form-select " placeholder="{{ __('Student ID/Name') }}" id="student_list"
                            name="user_id">
                            @foreach ($users as $user)
                                <option
                                    {{ @$student_id != null && $student_id == $user->id ? " selected='selected' " : '' }}
                                    value="{{ $user->id }}">{{ $user->full_name }}({{ $user->studentID }})</option>
                            @endforeach
                        </select>
                        <input id="fee_id" name="fee_id" type="hidden" readonly />
                    </div>
                </div> --}}
            </div>
            <div class="row">

                <div class="col-md-2 col-sm-12">
                    <div class="form-group">
                        <label for="last_name">@lang('Batch')</label>
                        <input id="batch" name="batch" type="text" class="form-control" readonly
                            placeholder="{{ __('Batch') }}" />
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="last_name">@lang('Branch')</label>
                        <input id="branch" name="branch" type="text" class="form-control" readonly
                            placeholder="{{ __('Branch Location') }}" />
                            <input id="location_id" name="location_id" type="hidden" class="form-control"  />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-12">
                    <div class="form-group">
                        <label for="last_name">@lang('Fee Type')</label>
                        <select class="form-select preview_installment" placeholder="{{ __('Fee Type') }}"
                            id="fee_type" name="fee_type">
                            @foreach (feeTypelist() as $type => $key)
                                <option value="{{ $type }}">({{ $key }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="col-md-2 col-sm-12">
                    <div class="form-group">
                        <label for="user_id">{{ __('Fee Amount') }}</label>
                        <input maxlength="10" id="amount" name="amount" type="text"
                            class="form-control preview_installment" placeholder="{{ __('Student Fee Amount') }}" />
                    </div>
                </div>
                <div class="col-md-2 col-sm-12">
                    <div class="form-group">
                        <label for="last_name">{{ __('Fee Disount Amount') }}</label>
                        <input maxlength="10" value="100" id="discount" name="discount" type="text"
                            class="form-control preview_installment" placeholder="{{ __('Discount Amount') }}" />

                    </div>
                </div>
                <div class="col-md-2  col-sm-12">
                    <div class="form-group">
                        <label for="installment_nos">{{ __('No of Installments') }}</label>
                        <input maxlength="10" value="1" id="installment_nos" name="installment_nos" type="text"
                            class="form-control preview_installment" placeholder="{{ __('No Of Installments') }}" />
                    </div>
                </div>


                <div class="col-md-2 col-sm-12">
                    For one time payment,provide 1 in no of installments.
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-sm-12" id="installment_preview">
                    <div class="form-group bg-info text-white  text-center">
                        <p class=" p-2">Installment amount will be
                            <span id="installment_amt">0</span>.Please save the fee details.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <input type="submit" value="Save Info" class="btn btn-primary">
            <input type="reset" value="Reset Info" class="btn btn-secondary">
        </div>
        <!--begin::Details-->

    </form>


</div>
@include('admin.fees.partials.installments')
@push('styles')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        let loadPaymentModal = () => {
            console.log("loadUserFeeInfo");
            $('#user_payment').html("Processing...");
            var user_selected = $('#student_list option:selected');
            $.ajax({
                type: 'post',
                url: " {{ route('admin.nextpayment') }} ",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "user_id": user_selected.val()
                },
                success: function(response) {
                    if (response.status == "success") {
                        let payment_content = response.payment_content;
                        $('#user_payment').html(payment_content);
                        $('#paid_date').datepicker({
                            format: 'yyyy-mm-dd', // You can adjust the format as needed
                            autoclose: true,
                            endDate: 'today', // Prevent selecting future dates
                        });
                    } else {
                        $('#user_payment').html("Failed to process");
                        swalError(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    swalError(xhr.responseText);
                }
            });
        }

        let notifyUser = (e) => {
            // swalConfirm('', this.item.data('title') ?? 'Are you sure you want to delete?', this.options)
            console.log("ld");
            swalConfirm('Are you sure you want notifiy User?')
                .then((result) => {
                    if (result.isConfirmed) {
                        this.data.delete_step = 'destroy';
                        swalLoader();
                        // this.run();
                    }
                });
        }
        let savePayment = () => {
            if( $('#payment_mode').val() =="" || $('#paid_date').val() =="" ){
                swalError(__("Fill the required fields marked (*)"));
                return false;
            }
            var formData = $('#save_installment').serialize()+ "&_token={{ csrf_token() }}";
            console.log("formData",formData);
            $.ajax({
                type: 'post',
                url: "{{ route('admin.save-fee-payment') }}",
                data:formData  ,
                success: function(response) {
                    $('#paymentModal').modal('hide');
                    loadUserInfo();
                    if (response.status == "success") {
                        swalSuccess(__(response.message));
                    } else {
                        swalError(__(response.message));
                    }
                },
                error: function(xhr, status, error) {
                    loadUserInfo();
                    $('#paymentModal').modal('hide');
                    swalError(__(xhr.responseJSON.message));
                }
            });
        }

        let manageInstallment = () => {
            console.log("loadUserInfo");

            let installment_nos = parseInt($('#installment_nos').val());
            if (installment_nos == 0) {
                installment_nos = 1;
                $('#installment_nos').val(1);
            }
            $('#installment_preview').hide();
            let amount = parseFloat($('#amount').val());
            if ($('#amount').val() > 0 && $('#installment_nos').val() > 1) {
                let discount = parseFloat($('#discount').val());
                let installment_amt = (amount - discount) / installment_nos;
                $('#installment_preview').fadeToggle("slow", "linear");
                $('#installment_amt').html(installment_amt.toFixed(2));
            }

        }
        $('#deleted').hide();
        $('#installment_preview').hide();
        let loadUserInfo = () => {
            console.log("loadUserInfo");
            var user_selected = $('#student_list option:selected');
            $('#deleted').hide();
            $.ajax({
                type: 'post',
                url: " {{ route('admin.get-student-info') }} ",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "user_id": user_selected.val()
                },
                success: function(response) {
                    if (response.status == "success") {
                        let info = response.info;
                        let installment_content = response.installment_content;
                        $('input[name="batch"]').val(info.batches);
                        $('input[name="branch"]').val(info.branch);
                        $('input[name="location_id"]').val(info.location_id);
                        
                        if (info.branch == undefined) {
                            $('#deleted').hide();
                        }
                        console.log(info.deleted);

                        $('input[name="amount"]').val(info.amount);
                        $('input[name="discount"]').val(info.discount);
                        $('input[name="installment_nos"]').val(info.installment_nos);
                        $('#fee_id').val(info.fee_id);
                        $('#fee_type').val(info.fee_type);

                        $('#installment_details').html(installment_content);

                    } else {
                        $('#message_text').text("");
                        $('input[name="title"]').val();
                    }
                },
                error: function(error) {
                    $('input[name="message"]').text("");
                }
            });
        }
        
        $(document).ready(function() {

           
        //    $(document).on('click', '#prepay1btn', function(event) {
        //     $('#prepay1').fadeToggle();
        //     });
            $(document).on('click', '#save_installment_btn', function(event) {
            savePayment();
            });

            // Initialize the form validation
            $('#manage-fee').validate({
                rules: {
                    user_id: {
                        required: true,
                    },
                    fee_type: {
                        required: true,
                    },
                    installment_nos: {
                        required: true,
                    },
                    amount: {
                        required: true,
                    },
                    discount: {
                        required: true,
                    },
                    branch_id:{
                        required: true,
                    }
                },
                messages: {
                    // Define custom error messages if needed
                },
                submitHandler: function(form) {
                    // Serialize form data
                    var formData = $(form).serialize();
                    let route = "{{ route('student-fees.store') }}";
                    let request_type = "POST";
                    formData += '&user_id='+$('#student_list').val();
                    if ($('#fee_id').val() != '') {
                        formData += '&_method=PUT';
                        request_type = "PUT";
                        route = "{{ route('student-fees.update', ['']) }}/" + $('#fee_id').val();
                    }
                    // Perform AJAX request to submit form data
                    $.ajax({
                        url: route,
                        type: request_type,
                        data: formData,
                        success: function(response) {
                            loadUserInfo();
                            if (response.status == "success") {
                                swalSuccess(__(response.message));
                            } else {
                                swalError(__(response.message));
                            }
                        },
                        error: function(xhr, status, error) {
                            swalError(__(xhr.responseJSON.message));
                        }
                    });
                }
            });

            // Bind the submit event
            $(document).on('submit', '#manage-fee', function(event) {
                event.preventDefault();
                // Manually trigger the validation
                $('#manage-fee').valid();
            });
            // setTimeout(() => {
            // $('#student_list option:selected').val(7).trigger('change');
            // }, 12400);

        });
        $(document).on('click', '#modelLoad', function(event) {
            loadPaymentModal();
        });


        window.addEventListener('load', function() {

            loadUserInfo();

            $(document).on('change', '.preview_installment', function(e) {
                manageInstallment();
            });

            /*$(document).on('click', '#notify_user', function(e) {
                notifyUser(e);
            });
            */
            $(document).on('change', '#student_list', function(e) {
                loadUserInfo();
            });
            
            
        });
    </script>
@endpush
