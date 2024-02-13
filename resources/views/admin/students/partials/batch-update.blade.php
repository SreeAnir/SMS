@php
    $locations = locationList();
    $batches = $user->student->batches;
    $batch_id = 0;
    $locaiton_id = 0;
    if ($batches->count() > 0) {
        $locaiton_id = $batches[0]->location_id;
        $batch_id = $batches[0]->id;
    }

@endphp
@if (@$user != null)
    <div class="card  border-light border p-2 shadow-sm rounded mini-table" id="updateBatch">
        <table class="table w-100 mx-auto  ">
            <tbody>
                <tr>
                    <th colspan="2" scope="col">
                        

                        <h6 class="text-center text-secondary d-flex d-flex justify-content-between border-bottom py-2  " >
                            <span><em class="fas fa-home"></em>
                            {{ __('Update student batch') }}</span></h6>
                         <span class="text-info font-weigh-normal">{{ __('You can update the student\'s batch from here.Student will recieve an email regarding this change.')}}
                         </span>
                    </th>

                </tr>
                <tr>
                    <th scope="col" width="40%">{{ __('Location') }}</th>
                    <th scope="col">
                       
                        @if(auth()->user()->location_id =="")
                        <select class="form-control" name="location_id" id="location_id">
                            <option value="">{{ __('Choose location') }}</option>
                            @foreach ($locations as $locaiton)
                                <option value="{{ $locaiton->id }}" data-attr="{{ $locaiton->id }}"
                                    @if ($locaiton->id == $locaiton_id) selected @endif>{{ $locaiton->name }}
                                </option>
                            @endforeach
                        </select>
                        @else 
                        <span>{{ auth()->user()->location->name }}</span>
                        <input type="hidden"   name="location_id" id="location_id" value="{{ auth()->user()->location_id }}" />
                        {{-- <select class="form-control" name="location_id" id="location_id">
                            <option value="{{ auth()->user()->location->id }}" data-attr="{{ auth()->user()->location->id }}"  selected >{{ auth()->user()->location->name }}
                            </option>
                        </select> --}}
                        @endif
                    </th>

                </tr>
                <tr>
                    <th scope="col">{{ __('Batch') }}</th>
                    <th scope="col" id="batch_select">
                        @include('admin.students.partials.batch-select')
                    </th>
                </tr>

            </tbody>
        </table>
        <div class="d-flex justify-content-start p-3">
            <button class="btn btn-success text-white mr-1" type="button" id="save_batch">
                @lang('Update Student Batch')
            </button>
            <button class="btn btn-dark mx-1" type="button" id="reset_batch">
                @lang('Cancel')
            </button>
        </div>
    </div>
@endif
@push('scripts')
    <script>
        $(document).ready(function() {
            document.getElementById('save_batch').addEventListener('click', function() {
                swalConfirm('', "Proceed with student batch updation ?").then((result) => {
            if (result.isConfirmed) {
                swalLoader();

                saveStudentBatch();

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
            if( $('#location_id').val() !=""){
                loadBatches( $('#location_id').val() );
            }
            $('#location_id').trigger('change');
        });

        function saveStudentBatch() {
            if ($('#batch_id').val() == "") {
                swalError("No batches selected.Please add one batch.");
                return false;
            }
            console.log("kd", $('#batch_id').val());
            let data = {
                "batch_id": $('#batch_id').val(),
                "student_id": "{{ $user->student->id }}",
                "location_id": $('#location_id').val()
            };
            $.ajax({
                url: "{{ route('save.student.batch') }}",
                type: 'post',
                data: data,
                success: function(response) {
                    if (response.status == 'error') {
                        swalError(response.message);
                    } else {
                        $('#batch_label').text($("#batch_id option:selected").text());
                        swalSuccess(response.message);
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
