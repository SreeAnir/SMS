@php

@endphp
@if (@$user != null)
    <div class="card  bg-white border-light border p-2 shadow-sm rounded mini-table" id="updateBatch">
        <form >
        <table class="table w-100 mx-auto  " style="max-width: 500px;">
            <tbody>
                <tr>
                    <th colspan="2" scope="col">
                        <h6
                            class="text-center text-secondary d-flex d-flex justify-content-between border-bottom py-2  ">
                            <span><i class="fas fa-id-badge"></i>
                                {{ __('Student Emp.Code for RFID') }}</span>
                        </h6>
                        <span
                            class="text-info font-weigh-normal">{{ __('Student RFID is linked with essl biometric attendance system.Please carefully add the Emp-Code from E-PUSH SERVER.') }}
                        </span>
                    </th>

                </tr>
                <tr>
                    <th scope="col" width="40%">{{ __('Emp-Code') }}</th>
                    <th scope="col">
                        
                        <input type="text" maxlength="5" style="max-width: 100px;" name="rfid" id="rfid" class="form-control" value="{{$user->rfid }}" />
                    </th>

                </tr>


            </tbody>
        </table>
        <div class="d-flex justify-content-center p-3" >
            <button class="btn btn-info text-white mr-1" type="button" id="save_rfid">
                @lang('Save')
            </button>
            <button class="btn btn-dark mx-1" type="reset" id="reset_rfid">
                @lang('Cancel')
            </button>

        </div>
        <p class="text-success p-2 text-center" id="info_rfid"></p>

        </form>
    </div>
@endif
@push('scripts')
    <script>
        $(document).ready(function() {
            
            document.getElementById('save_rfid').addEventListener('click', function() {
                swalConfirm('', "Proceed with student RFID updation ?").then((result) => {
                    if (result.isConfirmed) {
                        swalLoader();
                        saveRFID();

                    } else if (result.isDenied) {
                        swalError('You have cancelled the student update!', 'Cancelled', '');
                    }
                });

            });
            document.getElementById('location_id').addEventListener('change', function() {
                loadBatches(this.value);
            });
            document.getElementById('reset_batch').addEventListener('click', function() {
                location.reload();
            });
            if ($('#location_id').val() != "") {
                loadBatches($('#location_id').val());
            }
            $('#location_id').trigger('change');
        });

        function saveRFID() {
            if ($('#rfid').val() == "") {
                swalError("No RFID added.Please add and continue.");
                return false;
            }
            let data = {
                "rfid": $('#rfid').val(),
                // "student_id": "{{ $user->student->id }}",
            };
            $('#info_rfid').html('');
            $.ajax({
                url: "{{ route('save.student.rfid',['']) }}"+"/"+{{ $user->id}},
                type: 'post',
                data: data,
                success: function(response) {
                    if (response.status == 'error') {
                        swalError(response.message);
                    }else{
                        $('#info_rfid').html(response.info);
                        swalSuccess(response.message);
                        $('.alert.alert-danger').hide();
                    }

                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        swalError("Error", xhr.responseJSON.message);
                    } else {
                        swalError("Error", "Failed to proceed");
                    }
                    $('input[name="email"]').val('{{ @$user->email }}');
                }
            });
        }

        function loadBatches(location_id) {
            $.ajax({
                url: "{{ route('load.batches') }}",
                type: 'post',
                data: {
                    "location_id": location_id
                },
                success: function(response) {
                    if (response.status == 'error') {
                        swalError(response.message);
                    } else {
                        $('#batch_select').html(response.html);
                    }

                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        swalError("Error", xhr.responseJSON.message);
                    } else {
                        swalError("Error", "Failed to proceed");
                    }
                    $('input[name="email"]').val('{{ @$user->email }}');
                }
            });
        }
    </script>
@endpush
