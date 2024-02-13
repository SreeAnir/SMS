<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form action="{{ isset($event) ? route('events.update', [$event]) : route('events.store') }}"
                class="form-horizontal" method="POST" id="create-event">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <div id="form-alert" class="alert alert-warning">

                        </div>
                    </div>
                    @if (isset($event))
                        {{ method_field('PUT') }}
                    @endif
                    <h4 class="card-title">@lang('Event Info')</h4>

                    <div class="card-body border-top p-9">
                        <div class="row">

                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name">@lang('Title')</label>
                                    <input maxlength="250" type="text" class="form-control"
                                        value="{{ isset($event) ? $event->title : old('title') }}" name="title"
                                        placeholder="Title" value="">
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name">@lang('Location')</label>
                                    <input maxlength="250" type="text" class="form-control" name="address"
                                        value="{{ isset($event) ? $event->address : old('address') }}"
                                        placeholder="Address" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="user_id">{{ __('Event Date') }}</label>
                                    <input maxlength="10"
                                        value="{{ isset($event) ? $event->event_date : old('event_date') }}"
                                        value="{{ isset($event) ? $event->event_date : old('event_date') }}"
                                        id="event_date" name="event_date" type="text" class="form-control"
                                        placeholder="{{ __('Event date') }}" />
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name">{{ __('Event Time') }}</label>
                                    <input maxlength="10"
                                        value="{{ isset($event) ? $event->event_time : old('event_time') }}"
                                        id="event_time" name="event_time" type="text" class="form-control timepicker"
                                        placeholder="{{ __('Event Time') }}" />
                                    {{-- <select class="form-control timepicker" placeholder="{{ __('Event time') }}"   name="event_time">
                                            <option value="1">{{ __('Public') }}</option>
                                             
                                        </select> --}}
                                </div>
                            </div>
                            <div class="col-md-2  col-sm-12">
                                <div class="form-group">
                                    <label for="Visibility">{{ __('Visibility') }}</label>
                                    <select class="form-control" name="visibility">
                                        <option value="1">{{ __('Public') }}</option>
                                        <option value="2">{{ __('Private') }}</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="description">@lang('Description')</label>
                                    <textarea maxlength="250" rows="15" type="text" class="form-control" 
                                    name="description" placeholder="Description">{{ isset($event) ? $event->description : old('description') }}</textarea>
                                </div>
                            </div>


                        </div>


                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <input type="submit" value="Save Details" class="btn btn-primary">
                            <input type="reset" value="Reset Details" class="btn btn-secondary">
                        </div>
                    </div>
            </form>

        </div>
    </div>

    @push('styles')
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
        <script src="https://cdn.tiny.cloud/1/doa8i56s6tswmv0g45utt85adbiws61mm527toij63wks7oo/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

        <script>

            window.addEventListener('load', function() {
                tinymce.init({
                    selector: 'textarea',
                    plugins: ['directionality paste nonbreaking pagebreak hr anchor autolink lists link wordcount'],
                    toolbar1: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link |print preview media | forecolor backcolor',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: '',
                    mergetags_list: [
                    { value: 'First.Name', title: 'First Name' },
                    { value: 'Email', title: 'Email' },
                    ],
                    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
                });
                $('#create-event').validate({
                    rules: {
                        title: {
                            required: true,
                            maxlength: 250,
                        },
                        address: {
                            required: true,
                            maxlength: 250,
                        },
                        event_date: {
                            maxlength: 10,
                        },
                        event_time: {
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
                        event_date: {
                            required: "Event date is required",
                            maxlength: "Event date cannot be more than 10 characters",
                        },
                        event_time: {
                            required: "Event time is required",
                            maxlength: "Event time cannot be more than 5 characters",
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

            });
            $(document).ready(function() {
                $('#form-alert').hide();
                $('#event_date').datepicker({
                    format: 'yyyy-mm-dd', // You can adjust the format as needed
                    autoclose: true,
                    startDate: 'today', // Prevent selecting future dates
                });
                let default_time = ($('#event_time').val() != "" ? $('#event_time').val() : '10');
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
    @endpush
