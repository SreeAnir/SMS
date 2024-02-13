@php
    use App\Models\Notification;
    use App\Models\Status;
    $users = recpientList();
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="card bg-light">
            <form
                action="{{ isset($notification) ? route('notifications.update', [$notification]) : route('notifications.store') }}"
                class="form-horizontal" method="POST" id="create-notification">
                @csrf
                <div class="card-body bg-white">
                    <div class="form-group row">
                        <div id="form-alert" class="alert alert-warning">

                        </div>
                    </div>
                    @if (isset($notification))
                        {{ method_field('PUT') }}
                    @endif
                    <h4 class="card-title">@lang('Notification Info')</h4>

                    {{-- <div class="card-body border-top p-9"> --}}
                    <div class="alert alert-info text-black ">
                        **** Event notification details will be taken from the event.For other notification
                        types,ente title and description.
                        You can schedule it for a date or send right away on clicking "Send Now" button ****
                    </div>

                    <div class="row">

                        <div class="col-md-3  col-sm-12">


                            <div class="form-group">
                                <label for="notification_type">{{ __('Notification Type') }}
                                </label>
                                <select class="form-control" name="notification_type">
                                    <option value="">Select</option>
                                    @foreach (Notification::list() as $key => $value)
                                        <option
                                            {{ $key == @$notification->notification_type ? " selected ='selected' " : '' }}
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="col-md-6  col-sm-12 event_listing">
                            <div class="form-group">
                                <label for="event_id">{{ __('Event') }}
                                </label>
                                <select class="form-control" id="event_id" name="event_id">
                                    <option value="">Select Event</option>
                                    @foreach ($events as $key => $value)
                                        <option
                                            {{ $value->id == @$notification->notifiable_id ? " selected ='selected' " : '' }}
                                            value="{{ $value->id }}">{{ $value->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 title_message">
                            <div class="form-group">
                                <label for="last_name">@lang('Title')</label>
                                <input maxlength="250" type="text" class="form-control"
                                    value="{{ isset($notification) ? $notification->title : old('title') }}"
                                    name="title" placeholder="Title" value="">
                            </div>
                        </div>

                        <div class="col-md-9 col-sm-12 title_message">
                            <div class="form-group">
                                <label for="message">@lang('Message')</label>
                                <textarea id="message_text" maxlength="250" rows="3" type="text" class="form-control" name="message" placeholder="Description">{{ isset($notification) ? $notification->message : old('message') }}</textarea>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="user_id mr-2">{{ __('Schedule to send later') }} {{ @$notification->schedule_later }}</label>
                                <input type="checkbox"
                                    {{ @$notification->schedule_later ? " checked='checked' " : '' }}
                                    id="schedule_later" name="schedule_later"
                                    placeholder="{{ __('Schedule for later') }}" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 show_send_later">
                            <div class="form-group">
                                <label for="user_id">{{ __('Notification Date') }}</label>
                                <input maxlength="10"
                                    value="{{ isset($notification) ? $notification->notification_date : old('notification_date') }}"
                                    id="notification_date" name="notification_date" type="text" class="form-control"
                                    placeholder="{{ __('Notification date') }}" />
                            </div>
                        </div>

                        <div class="col-md-3  col-sm-12">
                            <div class="form-group">
                                <label for="status_id">{{ __('Publishing Status') }}
                                </label>
                                
                                <select class="form-control" name="status_id">
                                    <option value="">Select</option>
                                    @foreach (Status::notficationStatuslist() as $key => $value)
                                        <option

                                           {{ @$notification->status_id }} {{ $value->id == @$notification->status_id ? " selected ='selected' " : '' }}
                                            value="{{ $value->id }}">{{ $value->status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body  bg-white mt-2">
                    <h4 class="card-title">@lang('Recipients')</h4>
                    <div class="row">
                      
                        @if (isset($notification) && in_array(  $notification->status_id , [ Status::STATUS_SENT ,Status::STATUS_SENDING   ] ) )
                        @foreach ($notification->users as $recipient)
                        <div class="col-md-4 col-sm-12"> {{ $recipient->user->full_name  }} @include('common.status-badge', array('instance' =>  $recipient))</div>
                        @endforeach
                        @else
                            <div class="col-md-12 col-sm-12">

                                <div class="form-group">
                                    <label for="user_id">{{ __('Select all or select the students') }}</label>

                                    <select id="user_list" name="users[]" class="js-select2" multiple="multiple">
                                        <option value="all" data-badge="">{{ __('Select All') }} </option>
                                        @foreach ($users as $user)
                                            <option
                                                {{  isset($notification)  && in_array($user->id, $notification->users->pluck('user_id')->toArray()) ? " selected ='selected' " : '' }}
                                                value="{{ $user->id }}" data-badge="">
                                                {{ $user->full_name }},({{ $user->email }}) </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                        @endif

                    </div>
                </div>
                <div class="card-body  bg-white mt-2">

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                {{-- @if (isset($notification) && $notification->status_id == Status::STATUS_SENT) --}}
                                @if (isset($notification) && in_array(  $notification->status_id , [ Status::STATUS_SENT ,Status::STATUS_SENDING  ] ) )

                                    <div class="alert alert-success mt-2" role="alert">
                                        <h4 class="alert-heading"> <i class="me-2 mdi mdi-thumb-up"></i> Completed!
                                        </h4>
                                        <p>
                                            This Notification Already Send on
                                            <b>{{ $notification->notification_date }}</b>.
                                        </p>
                                        <hr>
                                        <p class="mb-0">
                                            You cannot modify the details.
                                        </p>
                                    </div>
                                @else
                                    <input type="submit" value="Send & Later"
                                        class="btn btn-primary show_send_later">
                                    <input type="submit" value="Save & Send Now"
                                        class="btn btn-success text-white show_send ">
                                    <input type="reset" value="Reset Details" class="btn btn-secondary">
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
        </div>


        </form>

    </div>
</div>
</div>


@push('styles')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .select2-container {
            min-width: 100%;
        }

        .select2-container--default .select2-selection--multiple {
            height: auto;
        }

        .select2-results__option {
            padding-right: 20px;
            vertical-align: middle;
        }

        .select2-results__option:before {
            content: "";
            display: inline-block;
            position: relative;
            height: 20px;
            width: 20px;
            border: 2px solid #e9e9e9;
            border-radius: 4px;
            background-color: #fff;
            margin-right: 20px;
            vertical-align: middle;
        }

        .select2-results__option[aria-selected=true]:before {
            font-family: fontAwesome;
            content: "\f00c";
            color: #fff;
            background-color: #f77750;
            border: 0;
            display: inline-block;
            padding-left: 3px;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #fff;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #eaeaeb;
            color: #272727;
        }

        .select2-container--default .select2-selection--multiple {
            margin-bottom: 10px;
        }

        .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
            border-radius: 4px;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #f77750;
            border-width: 2px;
        }

        .select2-container--default .select2-selection--multiple {
            border-width: 2px;
        }

        .select2-container--open .select2-dropdown--below {

            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);

        }

        .select2-selection .select2-selection--multiple:after {
            content: 'hhghgh';
        }

        /* select with icons badges single*/
        .select-icon .select2-selection__placeholder .badge {
            display: none;
        }

        .select-icon .placeholder {
            display: none;
        }

        .select-icon .select2-results__option:before,
        .select-icon .select2-results__option[aria-selected=true]:before {
            display: none !important;
            /* content: "" !important; */
        }

        .select-icon .select2-search--dropdown {
            display: none;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #121111;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        let status_id = '{{ @$notification->status_id }}';
        console.log(status_id);
        let checkSentStatus = () => {
            // check if status send ,if there is change in status reload the page
            // $.ajax({
            //                 type: 'post',
            //                 url: " {{ route('get-event-info') }} ",
            //                 data: {
            //                     "_token": "{{ csrf_token() }}",
            //                     "event_id": event_sel.val()
            //                 },
            //                 success: function(response) {
            //                     if (response.status == "success") {
            //                         $('#message_text').text(response.message);
            //                         $('input[name="title"]').val(response.title);
            //                     } else {
            //                         $('#message_text').text("");
            //                         $('input[name="title"]').val();
            //                     }
            //                 },
            //                 error: function(error) {
            //                     $('input[name="message"]').text("");
            //                 }
            //             });
        }
        let makeAllSelected = () => {
            var selectedOptionsWithoutAll = $('#user_list option:selected:not([value="all"])');
            if (selectedOptionsWithoutAll.length === $('#user_list option:not([value="all"])')
                .length) {
                $('#user_list option').prop('selected', true).trigger('change.select2');
            }
        }

        window.addEventListener('load', function() {
            makeAllSelected();
            $('.multi-selec2').select2();
            $(document).on('change', '#user_list', function(e) {
                var selectedValue = $(this).val();

                if (selectedValue === "all") {
                    // Select all options
                    $('#user_list option').prop('selected', true).trigger('change.select2');
                } else {
                    makeAllSelected();
                }
            });
            //$('.title_message').hide();
            $('#create-notification').validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 250,
                    },
                    address: {
                        required: true,
                        maxlength: 250,
                    },
                    notification_date: {
                        maxlength: 10,
                    },
                    notification_time: {
                        maxlength: 8,
                    },
                    visibility: {
                        required: true,
                        maxlength: 500,
                    },
                    description: {
                        required: true,
                        maxlength: 1000,
                    },
                },
                messages: {
                    title: {
                        required: 'Title is required',
                        maxlength: "Title cannot be more than 250 characters"
                    },
                    address: {
                        required: "Address is required",
                        maxlength: "Address cannot be more than 250 characters"
                    },
                    notification_date: {
                        required: "Notification date is required",
                        maxlength: "Notification date cannot be more than 10 characters",
                    },
                    notification_time: {
                        required: "Notification time is required",
                        maxlength: "Notification time cannot be more than 5 characters",
                    },
                    visibility: {
                        required: 'Visibility is required',
                    },
                    description: {
                        required: "Description is required",
                        maxlength: "Description cannot be more than 1000 characters",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });


            $('#form-alert').hide();
            handleScheduleLate();
            handleNotificationType();

            function handleScheduleLate() {
                let isChecked = $('#schedule_later').is(':checked');
                console.log(isChecked);
                if (isChecked) {
                    $('.show_send_later').show();
                    $('.hide_send_now').hide();
                    $('.show_send').hide();
                } else {
                    $('.hide_send_now').show();
                    $('.show_send_later').hide();
                    $('.show_send').show();
                }

            }

            function handleNotificationType() {
                let el = $('select[name="notification_type"]');
                let selectedValue = el.val();

                if (selectedValue == 2) {
                    // $('.title_message').hide();
                    $('.event_listing').show();
                } else {

                    // $('.title_message').show();
                    $('.event_listing').hide();
                }
            }
            function handleEventChange() {
                var event_sel = $('#event_id option:selected');
                 let msg ="";
                    // $('input[name="message"]').text(msg);
                        $.ajax({
                            type: 'post',
                            url: " {{ route('get-event-info') }} ",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "event_id": event_sel.val()
                            },
                            success: function(response) {
                                if (response.status == "success") {
                                    $('#message_text').text(response.message);
                                    $('input[name="title"]').val(response.title);
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
            $(document).on('change', 'select[name="event_id"]', function(e) {
                console.log(e);
                handleEventChange();
                
            });
            $(document).on('change', 'input[name="schedule_later"]', function(e) {
                handleScheduleLate();
            });
            $(document).on('change', 'select[name="notification_type"]', function(e) {
                handleNotificationType();


            });
            $('#notification_date').datepicker({
                format: 'yyyy-mm-dd', // You can adjust the format as needed
                autoclose: true,
                startDate: 'today', // Prnotification selecting future dates
            });
            let default_time = ($('#notification_time').val() != "" ? $('#notification_time').val() : '10');
            $('.timepicker').timepicker({
                timeFormat: 'h:mm p',
                interval: 30,
                minTime: '10',
                maxTime: '6:00pm',
                defaultTime: default_time,
                startTime: '10:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
        });
    </script>

    <script>
        $(".js-select2").select2({
            closeOnSelect: false,
            placeholder: "Select Users",
            allowHtml: true,
            allowClear: true,
            tags: true
        });
    </script>
@endpush
