@extends('layouts.admin.app')
@section('title', 'Show Batch Details')
{{-- @section('header_buttons') --}}

{{-- @endsection --}}
@section('content')
    <div id="success-msg-box" style="display:none;">
        @include('admin/batches/partials/success-msg')
    </div>
    <div id="error-msg" style="display:none;">
        @include('admin/batches/partials/error-msg')
    </div>

    @php
        $instance = $batch;
    @endphp
    @include('admin.batches.partials.details')

    <x-index-card>

         <x-slot:toolbar>  
    <h6 class="mx-2"> @lang('Students Enrolled')</h6>

            {{-- <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base"> --}}
                {{-- <a 1target="_blank" id="add-batch" type="button" class="btn btn-primary btn-lg">
                    @lang('+ Add Batch')
                </a>  

            {{-- </div> --}}
         </x-slot:toolbar> 

        {{-- <x-slot:filter id="users_filter">
            @include('admin.batches.partials.filter')
        </x-slot:filter> --}}
        <x-slot:table>
            {!! $dataTable->table() !!}
        </x-slot:table>
    </x-index-card>


@endsection
@include('common.datatable')

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).on('click', '#add-batch', function() {
            $('#add-batch-modal').modal('show');
        })
    </script>
    <script type="text/javascript">
        var BaseUrl = "{{ url('/') }}";
        $(document).ready(function() {
            $('.timepicker').timepicker({
                timeFormat: 'h:mm p',
                interval: 60,
                minTime: '12:00am', // Set minTime to 12:00am
                maxTime: '11:00pm', // Set maxTime to 12:00pm
                defaultTime: '6', // Default time (you can adjust this according to your needs)
                startTime: '12:00am',
                dynamic: false,
                dropdown: true,
                scrollbar: true,
                showDuration: true // Show duration dropdown
            });
            // Custom validation method for time format (HH:mm AM/PM)
            $.validator.addMethod("timeFormat", function(value, element) {
                // Regular expression for HH:mm AM/PM format
                var timeRegex = /^(1[0-2]|0?[1-9]):[0-5][0-9] (AM|PM)$/i;
                return this.optional(element) || timeRegex.test(value);
            }, "Please enter a valid time in HH:mm AM/PM format.");
            // Initialize form validation
            $('#create-batch').validate({
                rules: {
                    batch_name: {
                        required: true,
                    },
                    batch_time: {
                        required: true,
                        timeFormat: true
                    },
                    batch_location: {
                        required: true,
                    },
                },
                messages: {
                    // Define custom error messages if needed
                },
                submitHandler: function(form) {
                    // Serialize form data
                    var formData = $(form).serialize();

                    // Perform AJAX request to submit form data
                    $.ajax({
                        url: $(form).attr('action'),
                        type: $(form).attr('method'),
                        data: formData,
                        success: function(response) {
                            $("#create-batch")[0].reset();
                            $("#add-batch-modal").modal('hide');
                            if (response.status == "success") {
                                $('#success-msg').html("Batch created successfully.");
                                $('#success-msg-box').fadeIn('slow').delay(3000).fadeOut(
                                    'slow');

                                let table_id = 'batch-table';
                                if (table_id && window.LaravelDataTables[table_id]) {
                                    window.LaravelDataTables[table_id].draw();
                                }

                            } else {
                                $('#error-msg').fadeIn('slow').delay(3000).fadeOut('slow')
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            $('#error-msg').fadeIn('slow').delay(3000).fadeOut('slow')
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });

        $(document).on('click', '.edit-batch', function() {

            var batch_id = $(this).attr('data-id');
            $.ajax({
                type: 'get',
                url: BaseUrl + '/admin/batches/' + batch_id + '/edit',
                data: {
                    "_token": "{{ csrf_token() }}",

                },
                success: function(response) {
                    $('#edit-batch-body').html(response.data);
                    $('#update-batch').find('.timepicker').timepicker({
                        timeFormat: 'h:mm p',
                        interval: 60,
                        minTime: '12:00am',
                        maxTime: '11:00pm',
                        defaultTime: response.time,
                        startTime: '12:00am',
                        dynamic: false,
                        dropdown: true,
                        scrollbar: true,
                        showDuration: true
                    });
                    $('#edit-batch-modal').modal('show');

                },
                error: function(error) {
                    // Handle errors
                }
            });


        });
        $(document).on('submit', '#update-batch', function(event) {
            event.preventDefault();
            $('#update-batch').validate({
                rules: {
                    batch_name: {
                        required: true,
                    },
                    batch_time: {
                        required: true,
                        timeFormat: true
                    },
                    batch_location: {
                        required: true,
                    },
                },
                messages: {
                    // Define custom error messages if needed
                },
                submitHandler: function(form) {
                    // Serialize form data
                    var formData = $(form).serialize();

                    // Perform AJAX request to submit form data
                    $.ajax({
                        url: BaseUrl + '/admin/batches/update',
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            $("#update-batch")[0].reset();
                            $("#edit-batch-modal").modal('hide');
                            if (response.status == "success") {
                                $('#success-msg').html(
                                    "Batch detaisl updated successfully.");
                                $('#success-msg-box').fadeIn('slow').delay(3000).fadeOut(
                                    'slow');

                                let table_id = 'batch-table';
                                if (table_id && window.LaravelDataTables[table_id]) {
                                    window.LaravelDataTables[table_id].draw();
                                }

                            } else {
                                $('#error-msg').fadeIn('slow').delay(3000).fadeOut('slow')
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            $('#error-msg').fadeIn('slow').delay(3000).fadeOut('slow')
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

        });
    </script>
@endpush
